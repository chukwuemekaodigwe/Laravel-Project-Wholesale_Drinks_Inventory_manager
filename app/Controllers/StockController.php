<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Empties;
use App\Models\OutBoundStock;
use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function stocks(): Response
    {
        $stocks = Stock::getCummulativeStock();

        return Inertia::render('Dashboard/stocks', ['products' => $stocks]);
    }

    public function index(): Response
    {
        // for the index dashboad page
        $stocks = Stock::getCummulativeStock();
        return Inertia::render('Dashboard/index', ['products' => $stocks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addStockTable(): Response
    {
        return Inertia::render('Dashboard/addStocks', ['products' => Product::orderby('name', 'asc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function saveStock(Request $request): RedirectResponse
    {
        set_time_limit(90);
        $products = $request->products;
        $date = $request->dateIn;
        $batch = 'BAT-' . date('Ymd', strtotime($date));
        //dd($batch);
        foreach ($products as $product) {
            //dd($product);
            if (!empty($product['quantity'])) {

                $res = Stock::firstOrNew(
                    [

                        'cost_price' => $product['costprice'],
                        'selling_price' => $product['sellingprice'],
                        'batch_no' => $batch,
                        'product_id' => $product['id']

                    ]

                );

                $res->product()->associate($product['id']);
                $res->total_qty = $res->total_qty + $product['quantity'];
                $res->qtysold = $res->qtysold + 0;
                $res->created_at = date('Y-m-d H:i:s', strtotime($request->dateIn));
                $res->status = 0;
                $res->save();
                //dd($res);
                Empties::saveNew($product['category'], -$product['quantity'], $product['id'], $batch);
            }
        }

        return to_route('stocksReport', ['message' => 'successfully addede']);
    }


    public function updateStockTable(): Response
    {
        $products = Product::getCurrentStock();
        //dd($products);
        return Inertia::render('Dashboard/updateStockTable', ['products' => $products]);
    }

    /**
     * Save Updates from stock update table
     */
    public function saveUpdate(Request $request)
    {
        //set_time_limit(300);
        $products = $request->products;
        //dd($products);
        foreach ($products as $product) {
            if (($product['quantity'] !== 0) && empty($product['quantity'])) {
                //dd($product);
                continue;
            } else {

                $stocks = Stock::where('product_id', '=', $product['product_id'])->where('status', '=', 0)->get();

                $totalqty = $product['qty'];
                $i = 0;

                foreach ($stocks as $stock) {
                    //dd($stock);
                    $qty = $stock->total_qty - $stock->qtysold;
                    //dd($stock);
                    $remaining = $totalqty - $qty;
                    if ($remaining > 0) {
                        $qtysold = $qty;
                    } elseif ($remaining <= 0 && $totalqty >= 0) {
                        $qtysold = $totalqty;
                        //dd($qtysold);
                    } else {
                        break;
                    }

                    //dump($qtysold); dump($qty); die();
                    $stock->outBoundStock()->create([

                        'dateIn' => date('Y-m-d', strtotime($request->dateIn)),
                        'product_id' => $product['product_id'],
                        'qtysold' => $qtysold,
                        'total_earning' => $qtysold * $stock->selling_price,
                        'profit' => $qtysold * ($stock->selling_price - $stock->cost_price)

                    ]);

                    $stock->qtysold = $stock->qtysold + $qtysold;;
                    $stock->updated_at = date('Y-m-d', strtotime($request->dateIn));
                    if ($stock->total_qty == $stock->qtysold) {
                        $stock->status = 1;
                    }

                    $stock->save();

                    $totalqty = $remaining;
                    //dd($request->dateIn);
                }

                $emp =  Empties::saveNew(
                    $product['category'],
                    ($product['qty']),
                    $product['product_id']
                );
                //dd($stocks);
            }
        }

        return to_route('stocksReport');
    }


    public function stockReport(): Response
    {
        $stocks = DB::table('stocks')->selectRaw('count(id) as items, 
        sum(total_qty) as quantity, sum(qtysold) as sold, batch_no, 
        DATE_FORMAT(created_at, "%Y-%m-%d") as date_in')
            ->orderBy('batch_no', 'desc')
            ->groupBy('batch_no', 'date_in')
            ->paginate(25);

        return Inertia::render('Dashboard/stockRecords', ['stocks' => $stocks]);
    }


    public function stockReportByBatch($id): Response
    {
        $stock = DB::table('stocks')->where('batch_no', '=', $id)->rightJoin('products', 'stocks.product_id', '=', 'products.id')->select('stocks.*', 'products.name')->orderby('products.name', 'asc')->get();
        return Inertia::render('Dashboard/stockByBatch', ['stocks' => $stock, 'batch' => $id]);
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function outStock(): Response
    {
        $stock = DB::select('SELECT product_name FROM (SELECT sum(stocks.qtysold) as sold, sum(stocks.total_qty) as qty, products.name as product_name FROM products, stocks WHERE stocks.product_id = products.id GROUP BY products.id) as first WHERE sold = qty');

        ///dd($stock);
        return Inertia::render('Dashboard/outStocks', ['stocks' => $stock]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function stockBatchEdit($batch): Response
    {
        $stocks = Stock::where('stocks.batch_no', '=', $batch)->join('products', 'products.id', '=', 'stocks.product_id')->select('stocks.*', 'products.name', 'products.category', 'products.id as productId')->get();
        $dateIn = date('Y-m-d', strtotime(explode('-', $batch)[1]));

        return Inertia::render('Dashboard/editStock', ['products' => $stocks, 'edit' => true, 'dateIn' => $dateIn, 'batch' => $batch]);
    }

    public function saveEdit(Request $request,  $batch): RedirectResponse
    {
        set_time_limit(90);
        $products = $request->products;
        $date = $request->dateIn;
        $batch = 'BAT-' . date('Ymd', strtotime($date));

        foreach ($products as $product) {

            if (!empty($product['total_qty'])) {

                $res = Stock::firstOrNew(
                    [
                        'product_id' => $product['product_id'],
                        'batch_no' => $batch,
                        'id' => $product['id']
                    ]

                );

                Empties::updateRecord($res->total_qty, $product['productId'], $product['total_qty'], $batch);

                //$res->product()->associate($product['id']);
                $res->total_qty = $product['total_qty'];
                $res->cost_price = $product['cost_price'];
                $res->selling_price = $product['selling_price'];


                $res->created_at = date('Y-m-d H:i:s', strtotime($request->dateIn));
                if ($product['total_qty'] > $res->qtysold) {
                    $res->status = 0;
                }

                $res->save();
            }
        }

        return to_route('stocksReport', ['message' => 'successfully addede']);
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($batch): RedirectResponse
    {
        $deleted = Stock::where('batch_no', $batch)->delete();
        $deleteEmpty = Empties::deleteEmpties($batch);
        return to_route('stocksReport');
    }

    /**
     * Sales Report  Refers to the OutBoundStock Table
     */

    public function salesReport()
    {

        $salesIstPage = OutBoundStock::selectRaw('count(product_id) as items, dateIn')
        ->orderby('dateIn', 'desc')->groupBy('dateIn')->paginate(25)->withQueryString();
        //dd($salesIstPage);
        return Inertia::render('Dashboard/salesReport', ['stocks' => $salesIstPage]);
    }

    public function salesReportByDate($date)
    {
        $stocks = OutBoundStock::where('dateIn', date('Y-m-d H:i:s', strtotime($date)))
        ->join('products', 'products.id', '=', 'out_bound_stocks.product_id')
        ->groupBy('out_bound_stocks.product_id')
        ->selectRaw('SUM(out_bound_stocks.qtysold) as qtysold, SUM(out_bound_stocks.profit) as profit, 
        SUM(out_bound_stocks.total_earning) as earning, products.name')->orderby('products.name', 'asc')->get();

        return Inertia::render('Dashboard/salesReportByDate', ['stocks' => $stocks, 'dateIn' => $date]);
    }

    public function salesReportByProduct()
    {

        $date1 = time() - (60 * 60 * 24 * 60);
        $date2 = time() + (60 * 60 * 24);

        //BETWEEN date('Y-m-d H:i:s', $date1) AND date('Y-m-d H:i:s', $date2)
        // dd(date('Y-m-d H:i:s', $date1));
        $stocks = DB::select("SELECT b.name, sum(a.total_qty) as totalqty,
        sum(c.qtysold) as sold, sum(c.total_earning) as earning, sum(c.profit) as profit, b.id as productId 
        FROM stocks a, products b, out_bound_stocks c 
        WHERE a.product_id = b.id AND c.product_id = b.id AND a.deleted_at IS NULL AND c.deleted_at IS NULL 
        AND c.dateIn BETWEEN '" . date('Y-m-d H:i:s', $date1) . "' AND '" . date('Y-m-d H:i:s', $date2) ."'
         GROUP BY b.id ORDER BY b.name ASC");
        //  dd($stocks);
        return Inertia::render('Dashboard/salesReportByProduct', ['stocks' => $stocks, 'dates' => [date('Y-m-d', $date1), date('Y-m-d', $date2)]]);
    }

    /**
     * Below is sales report within date ranges shown on salesReportByProduct
     */

    public function salesReportByRange(Request $request)
    {

        if (!empty($request->dates)) {
            $day = $request->dates;

            $date1 = strtotime($day['from']) - (60 * 60 * 24 * 30);
            $date2 = strtotime($day['to']) + (60 * 60 * 24);
        } else {
            $date1 = time() - (60 * 60 * 24 * 30);
            $date2 = time() + (60 * 60 * 24);
        }
        //BETWEEN date('Y-m-d H:i:s', $date1) AND date('Y-m-d H:i:s', $date2)
        // dd(date('Y-m-d H:i:s', $date1));
        $stocks = DB::select("SELECT b.name, sum(a.total_qty) as totalqty,
        sum(c.qtysold) as sold, sum(c.sellingprice * c.qtysold) as earning, sum((c.sellingprice - c.costprice) * c.qtysold) as profit, b.id as productId 
        FROM stocks a, products b, out_bound_stocks c 
        WHERE a.product_id = b.id AND c.product_id = b.id AND a.deleted_at IS NULL AND c.deleted_at IS NULL 
        AND c.dateIn BETWEEN '" . date('Y-m-d H:i:s', $date1) . "' AND '" . date('Y-m-d H:i:s', $date2) . "' GROUP BY b.id ORDER BY b.name ASC");

        //return Inertia::render('salesReportByProduct', ['stocks' => $stocks, 'dates' => [date('Y-m-d', $date1), date('Y-m-d', $date2)]]);
        //return response(['stocks'=>$stocks]);
        return response()->json($stocks);
    }

    public function deleteSale($date)
    {
        //dd($date);
        OutBoundStock::where('dateIn', date('Y-m-d H:i:s', strtotime($date)))->delete();
        return to_route('salesReport', ['message' => 'Successfully deleted']);
    }
}

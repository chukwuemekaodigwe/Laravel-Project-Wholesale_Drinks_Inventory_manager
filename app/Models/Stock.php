<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'total_qty', 'cost_price', 'selling_price',
        'status', 'qtysold', 'batch_no'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function outBoundStock()
    {
        return $this->hasMany(OutBoundStock::class);
    }

    public function getStockByBatch($batch)
    {
        return Stock::where('batch_no', '=', $batch)->get();
    }

    public static function getCummulativeStock()
    {
        return $stocks = DB::table('stocks')
            ->selectRaw('count(stocks.id) as items, sum(stocks.total_qty) as quantity, 
        sum(stocks.qtysold) as sold, products.name, products.id, stocks.selling_price, 
        stocks.cost_price, products.image_url')
            ->where('stocks.total_qty', '>', 'stocks.qtysold')
            ->whereNot('stocks.status', '=', '1')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->groupBy('products.id', 'products.name', 'stocks.selling_price', 'stocks.cost_price')
            ->orderBy('products.name', 'asc')
            ->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Stock;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'category', 'image_url', 'quantity', 'costprice', 'sellingprice'
    ];

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public static function getCurrentStock(){

        
        return DB::table('stocks')
        ->where('stocks.total_qty', '>', 'stocks.qtysold')
        // ->where(function ($query) {
        //     $query->where('stocks.status', '!=', 1)
        //     ->where('stocks.updated_at', '<', date('Y-m-d', (time()+ (24*60*60*7 ))));
        //     })
        
        ->where('stocks.status', '=', 0)
        ->join('products', 'stocks.product_id', '=', 'products.id')
        ->selectRaw('(SUM(total_qty) - SUM(qtysold)) as exp_qty, products.name, products.category, stocks.product_id, products.quantity')
        ->groupBy('stocks.product_id')
        ->get();
    }

    public static function getProducts(){
        return Product::orderby('name', 'asc')->get();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Empties extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'quantity', 'product_id', 'batch_no'];

    public static function saveNew($brand, $qty, $product_id = '', $batch = '')
    {
        Empties::create([
            'brand' => $brand,
            'quantity' => $qty,
            'product_id' => $product_id,
            'batch_no'=> $batch
        ]);

        return true;
    }

    public static function getCurrentEmpties()
    {
        $empties = Empties::selectRaw('sum(quantity) as quantity, brand')
            ->groupBy('brand')
            ->orderBy('brand', 'asc')
            ->get();

        return $empties;
    }

    public static function updateRecord($oldqty, $prod_id, $newqty, $batch){
     $res = DB::table('empties')
     ->where('quantity', '=', -$oldqty)
     ->where('product_id', '=', $prod_id)
     ->where('batch_no', '=', $batch)
     ->update([
        'quantity' => -$newqty
        
     ]);
     
     
         
        //dd($res);
    }

    public static function deleteEmpties($batch){
        Empties::where('batch_no', $batch)->delete();
    }
}

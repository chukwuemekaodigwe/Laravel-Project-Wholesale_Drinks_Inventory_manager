<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutBoundStock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['qtysold', 'dateIn', 'product_id', 'profit', 'total_earning'];

    public function stock(){
        return $this->BelongsTo(Stock::class);
    }
}

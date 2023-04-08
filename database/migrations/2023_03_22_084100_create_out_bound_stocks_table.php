<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('out_bound_stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('stock_id');
            $table->integer('product_id')->nullable();
            $table->integer('qtysold')->nullable();
            $table->integer('total_earning')->nullable();
            $table->integer('profit')->nullable();
            $table->dateTime('dateIn')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('out_bound_stocks');
    }
};

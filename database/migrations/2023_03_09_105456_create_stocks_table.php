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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('batch_no')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('total_qty')->nullable();
            $table->integer('qtysold')->nullable();
            $table->integer('cost_price')->nullable();
            $table->integer('selling_price')->nullable();
            $table->integer('status')->nullable()->comment('1==sold, 0==not-yet');

            $table->softDeletesDatetime();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};

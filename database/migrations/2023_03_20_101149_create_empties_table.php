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
        Schema::create('empties', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('brand');
            $table->integer('product_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('batch_no')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empties');
    }
};

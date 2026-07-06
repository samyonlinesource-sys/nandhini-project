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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('brand_id');
            $table->string('user_id');
            $table->string('user_name');
            $table->string('product_image')->nullable();
            $table->string('product_name');
            $table->string('product_code')->unique();
            $table->string('description')->nullable();
            $table->integer('quantity');
            $table->integer('alert_quantity');
            $table->datetime('expiry');
            $table->integer('MRP');
            $table->integer('purchase_price');
            $table->integer('sales_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
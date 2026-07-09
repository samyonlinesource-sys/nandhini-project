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
        Schema::create('purchase', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code')->unique();
            $table->date('purchase_date')->nullable();
            $table->integer('amount');
            $table->integer('grant_total')->nullable();
            $table->string('purchase_description')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('status')->default('active');
            $table->string('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase');
    }
};
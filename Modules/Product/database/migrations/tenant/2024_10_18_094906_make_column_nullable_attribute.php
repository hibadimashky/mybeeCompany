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
        Schema::table('product_product_attribute', function (Blueprint $table) {
            $table->string('SKU')->nullable()->change();
            $table->string('barcode')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_product_attribute', function (Blueprint $table) {
            $table->string('SKU')->nullable(false)->change();
            $table->string('barcode')->nullable(false)->change();
        });
    }
};
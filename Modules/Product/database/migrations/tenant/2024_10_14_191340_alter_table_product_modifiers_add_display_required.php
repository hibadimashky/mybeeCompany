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
        Schema::table('product_product_modifiers', function (Blueprint $table) {
          
            $table->boolean('display_order');
             });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
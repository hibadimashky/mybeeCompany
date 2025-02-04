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
        Schema::table('product_linked_combos_upcharges', function (Blueprint $table) {
            $table->unsignedBigInteger('combo_id')->nullable();
            $table->foreign('combo_id')              // Foreign key constraint
            ->references('id')                    // References the id on the categories table
            ->on('product_product_combos');
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

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
        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->string('payment_type')->nullable()->change();
            $table->string('method')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->integer('payment_type')->nullable()->change();
            $table->integer('method')->nullable()->change();
        });
    }
};
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
        Schema::create('employee_administrative_users_establishments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('employee_administrative_users')->cascadeOnDelete();
            $table->foreignId('establishment_id')->constrained('establishment_establishments')->cascadeOnDelete()->name('fk_establishment_id');
            $table->foreignId('permissionSet_id')->constrained('employee_permission_sets')->cascadeOnDelete()->name('fk_permission_set_id');
            $table->unique(['user_id','establishment_id'], 'est_user_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrative_users_establishments');
    }
};

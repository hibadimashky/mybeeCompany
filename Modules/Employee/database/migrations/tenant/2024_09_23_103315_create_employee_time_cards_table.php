<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_time_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employee_employees')->nullOnDelete();
            $table->timestamp('clockInTime')->nullable();
            $table->timestamp('clockOutTime')->nullable();
            $table->decimal('hoursWorked', 5, 2)->nullable();
            $table->decimal('overtimeHours', 5, 2)->nullable();
            $table->date('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_time_cards');
    }
};

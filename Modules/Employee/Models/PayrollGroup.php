<?php

namespace Modules\Employee\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PayrollGroup extends BaseScheduleModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Payroll::class, 'payroll_group_id', 'id', 'id', 'employee_id');
    }
    
}

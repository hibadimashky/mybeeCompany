<?php

namespace Modules\Employee\Services;


class ShiftFilters
{
    public function __construct(protected array $filters) {
    }

    public function applyFilters($request, $employees)
    {
        foreach ($this->filters as $filter) {
            $filterValue = $request->{$filter};

            if (isset($filterValue) && $filterValue !== 'all') {
                $this->{$filter}($filterValue, $employees);
            }
        }
    }

    public function filter_role($value, $employees)
    {
        $employees->whereHas('allRoles', fn($query) => $query->where('role_id', $value));
    }

    public function filter_establishment($value, $employees)
    {
        $employees->where('establishment_id', $value);
    }

    public function filter_employee_status($value, $employees)
    {
        $employees->where('pos_is_active', $value);
    }
}

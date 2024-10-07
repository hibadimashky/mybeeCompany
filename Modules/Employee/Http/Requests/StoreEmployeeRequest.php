<?php

namespace Modules\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'name_en' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'unique:employee_employees,email'],
            'password' => ['required', Password::default()],
            'phoneNumber' => ['digits_between:10,15'],
            'employmentStartDate' => ['required', 'date'],
            'PIN' => ['required', 'digits_between:4,5', 'numeric', 'unique:employee_employees,pin'],
            'image' => ['image', 'max:3072'],
            'isActive' => ['required', 'boolean'],
            'role' => ['nullable', 'exists:roles,id']
            // 'wage' => ['nullable', ''],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
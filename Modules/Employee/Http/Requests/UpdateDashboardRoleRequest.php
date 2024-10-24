<?php

namespace Modules\Employee\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDashboardRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $notAjaxValidate = !str_contains(request()->url(), 'validate');
        return [
            'permissionSetName' => [Rule::requiredIf($notAjaxValidate), 'string', 'max:50'],
            'isActive' => [Rule::requiredIf($notAjaxValidate), 'boolean'],
            'rank' => [Rule::requiredIf($notAjaxValidate), 'numeric', 'max_digits:3'],
            'permissions' => ['array', 'nullable'],
            'permissions.*' => ['integer', Rule::exists('permissions', 'id')->where('type', 'ems')]
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

@props([
    'role_select_value',
    'establishment_select_value',
    'wage_value',
    'default_selection' => null,
    'default_selection_value' => null,
    'index',
    'roles',
    'establishments',
    'disabled' => false
])
<div data-repeater-item class="d-flex flex-wrap align-items-center gap-3">
    <x-form.input-div class="w-100"> 
        <x-form.select name="role_wage_repeater[{{ $index }}][role]" :options="$roles" :errors="$errors" :disabled=$disabled
            placeholder="{{ __('employee::fields.role') }}" value="{{ $role_select_value }}" />
    </x-form.input-div>
    <x-form.input-div class="w-100">
        <x-form.select name="role_wage_repeater[{{ $index }}][establishment]" data_allow_clear="false" :disabled=$disabled
            :options="$establishments" :errors="$errors" required default_selection="{{ $default_selection }}"
            default_selection_value="{{ $default_selection_value }}" value="{{ $establishment_select_value }}" />
    </x-form.input-div>
    <x-form.input-div class="w-100">
        <x-form.input :errors="$errors" type="number" placeholder="{{ __('employee::fields.wage') }}" :disabled=$disabled
            name="role_wage_repeater[{{ $index }}][wage]" value="{{ $wage_value }}" />
    </x-form.input-div>
    <button type="button" data-repeater-delete class="btn btn-sm btn-icon btn-light-danger" @disabled($disabled)>
        <i class="ki-outline ki-cross fs-1"></i>
    </button>
</div>

@props(['permissionSets', 'establishments', 'administrativeUser' => null, 'disabled' => false])
<label @class(['form-label'])>@lang('employee::fields.administrative_permission_set')</label>
<div id="dashboard_role_repeater">
    <div class="form-group">
        <div data-repeater-list="dashboard_role_repeater" class="d-flex flex-column gap-3">
            @foreach (old('dashboard_role_repeater', $administrativeUser?->permissionSets->isEmpty() ? [null] : $administrativeUser?->permissionSets ?? [null]) as $index => $permissionSet)
                <div data-repeater-item class="d-flex flex-wrap align-items-center gap-3">
                    <x-form.input-div class="w-100">
                        <x-form.select name="dashboard_role_repeater[{{ $index }}][dashboardRole]" :disabled=$disabled
                            optionName="permissionSetName" :options="$permissionSets" :errors="$errors" data_allow_clear="false"
                            placeholder="{{ __('employee::fields.role') }}" :default_selection_value=null
                            value="{{ is_array($permissionSet) ? $permissionSet['dashboardRole'] ?? '' : $permissionSet?->id }}" />
                    </x-form.input-div>
                    <x-form.input-div class="w-100">
                        <x-form.select name="dashboard_role_repeater[{{ $index }}][establishment]" :disabled=$disabled
                            data_allow_clear="false" :options="$establishments" :errors="$errors" 
                            value="{{ is_array($permissionSet) ? $permissionSet['establishment'] ?? '' : $permissionSet?->pivot->establishment_id }}" />
                    </x-form.input-div>
                    <button type="button" data-repeater-delete class="btn btn-sm btn-icon btn-light-danger" @disabled($disabled)>
                        <i class="ki-outline ki-cross fs-1"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group mt-7">
        <button type="button" data-repeater-create class="btn btn-sm btn-light-primary" @disabled($disabled)>
            <i class="ki-outline ki-plus fs-2"></i>@lang('employee::general.add_more_roles')</button>
    </div>
</div>

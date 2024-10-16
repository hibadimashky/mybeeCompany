@props(['permissionSets', 'establishments', 'administrativeUser' => null])
<label @class(['form-label'])>@lang('employee::fields.administrative_permission_set')</label>
<div id="dashboard_role_repeater">
    <div class="form-group">
        <div data-repeater-list="dashboard_role_repeater" class="d-flex flex-column gap-3">
            @foreach (old('dashboard_role_repeater', $administrativeUser?->permissionSets->isEmpty() ? [null] : $administrativeUser?->permissionSets ?? [null]) as $index => $permissionSet)
                <div data-repeater-item class="d-flex flex-wrap align-items-center gap-3">
                    <x-form.input-div class="w-100">
                        <x-form.select name="dashboard_role_repeater[{{ $index }}][dashboardRole]"
                            optionName="permissionSetName" :options="$permissionSets" :errors="$errors"
                            placeholder="{{ __('employee::fields.role') }}"
                            value="{{ is_array($permissionSet) ? $permissionSet['dashboardRole'] ?? '' : $permissionSet?->id }}" />
                    </x-form.input-div>
                    <x-form.input-div class="w-100">
                        <x-form.select name="dashboard_role_repeater[{{ $index }}][establishment]"
                            data_allow_clear="false" :options="$establishments" :errors="$errors" required
                            value="{{ is_array($permissionSet) ? $permissionSet['establishment'] ?? '' : $permissionSet?->pivot->establishment_id }}" />
                    </x-form.input-div>
                    <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-icon btn-light-danger">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group mt-7">
        <a href="javascript:;" data-repeater-create class="btn btn-sm btn-light-primary">
            <i class="ki-outline ki-plus fs-2"></i>@lang('employee::general.add_more_roles')</a>
    </div>
</div>

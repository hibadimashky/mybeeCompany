@extends('employee::layouts.master')

@section('title', __('employee::general.edit_role'))

@section('content')
    <form id="edit_role_form" class="form d-flex flex-column flex-lg-row" method="POST" enctype="multipart/form-data"
        action="{{ route('dashboard-roles.update', ['dashboardRole' => $dashboardRole]) }}">
        @method('patch')
        @csrf
        <x-employee::dashboard-roles.form :dashboardRole=$dashboardRole :modules=$modules :rolePermissions=$rolePermissions formId="edit_role_form"/>
    </form>
@endsection

@section('script')
    @parent
    <script src="{{ url('modules/employee/js/create-edit-role.js') }}"></script>
    <script src="{{ url('modules/employee/js/create-edit-dashboard-role.js') }}"></script>
    <script>
        "use strict";
        $(document).ready(function() {
            roleForm('edit_role_form', "{{ route('dashboard-roles.update.validation') }}");
            dashboardRolePermissionsForm();
            fixedTableHeader();
        });
    </script>
@endsection

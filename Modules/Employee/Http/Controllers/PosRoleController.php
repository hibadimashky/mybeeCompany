<?php

namespace Modules\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Modules\Employee\Classes\Tables;
use Modules\Employee\Http\Requests\StoreRoleRequest;
use Modules\Employee\Http\Requests\UpdateRoleRequest;
use Modules\Employee\Models\Role;

class PosRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $roles = Role::
                select('id', 'name', 'guard_name', 'department', 'rank');
            return Tables::getRoleTable($roles);
        }
        $columns = Tables::getRoleColumns();
        return view('employee::pos-roles.index', compact('columns'));
    }

    public function createLiveValidation(StoreRoleRequest $request)
    {
    }

    public function updateLiveValidation(UpdateRoleRequest $request)
    {
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Role::departments();
        return view('employee::pos-roles.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        DB::beginTransaction();
        $role = Role::create($request->safe()->all());
        DB::commit();
        if ($role) {
            return redirect()->route('roles.index')->with('message', __('employee::responses.role_created_successfully'));
        } else {
            return redirect()->route('roles.index')->with('error', __('employee::responses.something_wrong_happened'));
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('employee::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $departments = Role::departments();
        return view('employee::pos-roles.edit', compact('role', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        DB::beginTransaction();
        $updated = $role->update($request->safe()->all());
        DB::commit();
        if ($updated) {
            return redirect()->route('roles.index')->with('message', __('employee::responses.role_updated_successfully'));
        } else {
            return redirect()->route('roles.index')->with('error', __('employee::responses.something_wrong_happened'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $delete = $role->delete();
        if ($delete) {
            return response()->json(['message' => __('employee::responses.role_deleted_successfully')]);
        } else {
            return response()->json(['error' => __('employee::responses.something_wrong_happened')], 500);
        }
    }
}
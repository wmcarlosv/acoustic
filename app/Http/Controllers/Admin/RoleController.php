<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('role_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::with('permissions')->get();
        return view('admin.role.roleTable', compact('roles'));
    }

    public function create()
    {
        abort_if(Gate::denies('role_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $permissions = Permission::get();
        return view('admin.role.roleCreate', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'permissions' => 'bail|required',
        ]);

        $role = Role::create(['name' => $request->name]);
        $per =  Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($per);
        
        return redirect()->route('role.index')->withStatus(__('Role Created Successfully.'));
    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_if(Gate::denies('role_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = Role::with('permissions')->find($id);
        $permissions = Permission::get();
        return view('admin.role.roleEdit', compact('permissions','role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
        ]);
        $role = Role::find($id);
        if($request->permissions != null){
            $per =  Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($per);
        } else {
            $role->syncPermissions([]);
        }
        return redirect()->route('role.index')->withStatus(__('Role Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $role = Role::find($id);
        $users = User::role($role->name)->get();
        foreach($users as $user) {
            $user->removeRole($role->name);
        }
        $role->syncPermissions([]);
        $role->delete();
        return response()->json(['success' => true, 'msg' => __('Role Deleted Successfully.')], 200);
    }
}

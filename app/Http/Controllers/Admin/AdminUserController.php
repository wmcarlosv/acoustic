<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use Hash;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('admin_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = User::orderBy('id','desc')->get();
        return view('admin.admin_user.adminUserTable',compact('users'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $roles = Role::where('name','!=','Super Admin')->get();
        return view('admin.admin_user.adminUserCreate', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'email' => 'bail|required|email|unique:users',
            'roles' => 'bail|required',
            'password' => 'bail|required|min:6|max:15',
            'confirm_password' => 'bail|required|same:password',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;
        $user->password =  Hash::make($request->password);
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'AdminUser_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/user');
            $image->move($destinationPath, $name);
            $user->image = $name;
        }
        $user->save();
        $user->assignRole($request->input('roles', []));
        return redirect()->route('admin-user.index')->withStatus(__('Admin User Created Successfully.'));
    }
    
    public function edit($id)
    {
        abort_if(Gate::denies('admin_user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user = User::find($id);
        if($user->hasRole('Super Admin')) {
            return abort('403');
        }
        $roles = Role::where('name','!=','Super Admin')->get();
        return view('admin.admin_user.adminUserEdit', compact('roles','user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        if ($request->has('status')) {
            $user->status = $request->status;
        }
        if(isset($request->image))
        {
            if($user->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/image/user/'. $user->image))){
                    \File::delete(public_path('/image/user/'. $user->image));
                }
            }
            $image = $request->file('image');
            $name = 'AdminUser_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/user');
            $image->move($destinationPath, $name);
            $user->image = $name;
        }
        $user->save();

        $user->syncRoles($request->input('roles', []));
        
        return redirect()->route('admin-user.index')->withStatus(__('Admin User Updated Successfully.'));
    }



    public function destroy($id)
    {
        //
    }
}

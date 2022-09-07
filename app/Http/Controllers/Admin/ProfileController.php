<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.profile', compact('user'));
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show()
    {
       
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->hasFile('image'))
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
        return redirect()->back()->withStatus(__('Profile Updated Successfully.'));
    }

    
    public function changepassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:6'],
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'string', 'min:6','same:new_password'],
        ]);
        if (Hash::check($request->current_password, Auth::user()->password))
        {
            $password = Hash::make($request->new_password);
            User::find(Auth::user()->id)->update(['password'=>$password]);
        } else {
            return redirect()->back()->withErrors([__('Password not change.')]);
        }
        return redirect()->back()->withStatus(__('Password Changed Successfully.'));
    }

}

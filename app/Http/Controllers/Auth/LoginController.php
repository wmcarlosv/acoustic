<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use Auth;
use Hash;
use Redirect;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo() {
        $has = Auth::user()->hasPermissionTo('admin_dashboard');
        $is_admin = Auth::user()->hasRole('Super Admin');
        if($has || $is_admin) {
            return '/admin/dashboard';
        }
        return '/admin/profile';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function installer()
    {
        return view("installer");
    }

    public function admin_login()
    {
        if (!env('DB_DATABASE')) {
            return view("setup");
        }
        Auth::logout();
        return view('admin.login.login');
    }

    public function admin_login_check(Request $request)
    {
        $userdata = array(
            'email' => $request->email,
            'password' => $request->password,
            'status' => 1
        );
        $remember = $request->get('remember');
        if (Auth::attempt($userdata,$remember))
        {
            $user = User::find(Auth::user()->id);
            $user->last_login = Carbon::now()->toDateTimeString();
            $user->save();

            if(Auth::user()->hasRole('Super Admin')) {
                if(Auth::user()->hasPermissionTo('admin_dashboard') || Auth::user()->hasRole('Super Admin')) {
                    return redirect('/admin/dashboard');
                }
                return redirect('/admin/profile');
            }
            else {
                return redirect('/admin/profile');
            }
        }
        else
        {
            return Redirect::back()->withErrors(['Invalid Email or Passoword']);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
        return redirect('/login');
    }

     
    public function saveEnvData(Request $request)
    {
        $data['DB_HOST']=$request->db_host;
        $data['DB_DATABASE']=$request->db_name;
        $data['DB_USERNAME']=$request->db_user;
        $data['DB_PASSWORD']=$request->db_pass;
        
        $envFile = app()->environmentFilePath();
        
        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $str .= "\n";
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                    // If key does not exist, add it
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
                }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){
                return response()->json(['data' => null,'success'=>false], 200);
            }
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            return response()->json([ 'data' => null,'success'=>true], 200);    
        }
    }
      
    public function saveAdminData(Request $request)
    {
        $set = Setting::first();
        $set->license_client_name = $request->client_name;
        $set->license_code = $request->license_code;
        $set->license_status = 1;
        $set->save();
        User::role('Super Admin')->update(['email' => $request->email, 'password' => Hash::make($request->password)]);

        return response()->json([ 'data' => url('/login'),'success'=>true], 200);    
    }
}

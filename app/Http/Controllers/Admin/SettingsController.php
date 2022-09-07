<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use LicenseBoxAPI;

class SettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('settings_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();
        return view('admin.settings', compact('setting'));
    }
    
    public function general_setting(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $setting = Setting::first();
        
        $setting->share_url = $request->share_url;
        $setting->trending_challenge = $request->trending_challenge;
        $setting->color = $request->color;

        $setting->save();
        return redirect()->route('settings')->withStatus(__('General Settings Updated Successfully.'));
    }

    public function video_setting(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'vid_qty' => 'bail|required',
        ]);
        $setting = Setting::first();
        
        if($request->hasFile('watermark'))
        {
            if(\File::exists(public_path('/image/app/'. $setting->watermark))){
                \File::delete(public_path('/image/app/'. $setting->watermark));
            }
            $image = $request->file('watermark');
            $name = 'Watermark_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $setting->watermark = $name;
        }

        $setting->auto_approve = $request->has('auto_approve') ? 1 : 0;
        $setting->is_watermark = $request->has('is_watermark') ? 1 : 0;
        $setting->vid_qty = $request->vid_qty;
        $setting->save();
        return redirect()->route('settings')->withStatus(__('Video Settings Updated Successfully.'));
    }

    public function push_notification(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'app_id' => 'bail|required_if:notification,1',
            'api_key' => 'bail|required_if:notification,1',
            'auth_key' => 'bail|required_if:notification,1',
            'project_number' => 'bail|required_if:notification,1',
        ]);
        
        $setting = Setting::first();
        $setting->notification = $request->has('notification') ? 1 : 0;
        
        $setting->app_id = $request->app_id;
        $setting->api_key = $request->api_key;
        $setting->auth_key = $request->auth_key;
        $setting->project_no = $request->project_number;
        $setting->save();

        $data = [
            'APP_ID' => $request->app_id,
            'REST_API_KEY' => $request->api_key,
            'USER_AUTH_KEY' => $request->auth_key,
        ];
        $this->update_env($data);

        return redirect()->route('settings')->withStatus(__('Push Notification Settings Updated Successfully.'));
    }

    public function email_settings(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'mail_host' => 'bail|required',
            'mail_port' => 'bail|required',
            'mail_username' => 'bail|required',
            'mail_password' => 'bail|required',
            'sender_email' => 'bail|required',
            'main_encryption' => 'bail|required',
        ]);
        
        $setting = Setting::first();
        
        $setting->mail_host = $request->mail_host;
        $setting->mail_port = $request->mail_port;
        $setting->mail_username = $request->mail_username;
        $setting->mail_password = $request->mail_password;
        $setting->sender_email = $request->sender_email;
        $setting->main_encryption = $request->main_encryption;
        $setting->save();
        
        $data = [
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_FROM_ADDRESS' => $request->sender_email,
            'MAIL_ENCRYPTION' => $request->main_encryption,
        ];
        $this->update_env($data);

        return redirect()->route('settings')->withStatus(__('Email Settings Updated Successfully.'));
    }

    public function verification_settings(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'twilio_acc_id' => 'bail|required_if:verification_via,sms',
            'twilio_auth_token' => 'bail|required_if:verification_via,sms',
            'twilio_phone_no' => 'bail|required_if:verification_via,sms',
        ]);
        
        $setting = Setting::first();
        if($request->verification_via == "email") {
            $setting->verify_sms = 0;
            $setting->verify_email = 1;
        } else {
            $setting->verify_sms = 1;
            $setting->verify_email = 0;
        }
        
        $setting->is_verify = $request->has('verification') ? 1 : 0;
        $setting->twilio_acc_id = $request->twilio_acc_id;
        $setting->twilio_auth_token = $request->twilio_auth_token;
        $setting->twilio_phone_no = $request->twilio_phone_no;

        $setting->save();
        return redirect()->route('settings')->withStatus(__('Verification Settings Updated Successfully.'));
    }
    
    public function app_info(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'app_name' => 'bail|required',
            'app_version' => 'bail|required',
        ]);
        
        $setting = Setting::first();
        
        if($request->hasFile('color_logo'))
        {
            if(\File::exists(public_path('/image/app/'. $setting->color_logo))){
                \File::delete(public_path('/image/app/'. $setting->color_logo));
            }
            $image = $request->file('color_logo');
            $name = 'Color_Logo_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $setting->color_logo = $name;
        }
        
        if($request->hasFile('white_logo'))
        {
            if(\File::exists(public_path('/image/app/'. $setting->white_logo))){
                \File::delete(public_path('/image/app/'. $setting->white_logo));
            }
            $image = $request->file('white_logo');
            $name = 'White_Logo_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $setting->white_logo = $name;
        }
         
        if($request->hasFile('favicon'))
        {
            if(\File::exists(public_path('/image/app/'. $setting->favicon))){
                \File::delete(public_path('/image/app/'. $setting->favicon));
            }
            $image = $request->file('favicon');
            $name = 'Favicon_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $setting->favicon = $name;
        }
        
        $setting->app_name = $request->app_name;
        $setting->app_version = $request->app_version;
        $setting->app_footer = $request->app_footer;

        $setting->save();
        $data = [
            'APP_NAME' => $request->app_name,
        ];
        $this->update_env($data);

        return redirect()->route('settings')->withStatus(__('App Information Updated Successfully.'));
    }

    public function advertisement()
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();
        return view('admin.advertisement', compact('setting'));
    }

    public function admobUpdate(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'android_admob_app_id' => 'bail|required_if:admob,1',
            'android_banner' => 'bail|required_if:admob,1',
            'android_interstitial' => 'bail|required_if:admob,1',
            'android_native' => 'bail|required_if:admob,1',
            'ios_admob_app_id' => 'bail|required_if:admob,1',
            'ios_banner' => 'bail|required_if:admob,1',
            'ios_interstitial' => 'bail|required_if:admob,1',
            'ios_native' => 'bail|required_if:admob,1',

            'facebook_init' => 'bail|required_if:facebook,1',
            'facebook_banner' => 'bail|required_if:facebook,1',
        ]);
        $setting = Setting::first();
        $setting->admob = $request->has('admob') ? 1 : 0;
        $setting->android_admob_app_id = $request->android_admob_app_id;
        $setting->android_banner = $request->android_banner;
        $setting->android_interstitial = $request->android_interstitial;
        $setting->android_native = $request->android_native;
        $setting->ios_admob_app_id = $request->ios_admob_app_id;
        $setting->ios_banner = $request->ios_banner;
        $setting->ios_interstitial = $request->ios_interstitial;
        $setting->ios_native = $request->ios_native;
        
        $setting->facebook = $request->has('facebook') ? 1 : 0;
        $setting->facebook_init = $request->facebook_init;
        $setting->facebook_banner = $request->facebook_banner;
        $setting->save();
        return redirect()->route('advertisement')->withStatus(__('Advertisement Settings Updated Successfully.'));
    }
    
    public function license(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $request->validate([
            'license_key' => 'bail|required',
            'license_client_name' => 'bail|required',
        ]);
        $api = new LicenseBoxAPI();
        $activate_response = $api->activate_license($request->license_key, $request->license_client_name);
        if($activate_response['status'] === true)
        {
            $setting = Setting::first();
            
            $setting->license_code = $request->license_key;
            $setting->license_client_name = $request->license_client_name;
            $setting->license_status = 1;
            $setting->save();
            return redirect('admin/dashboard');
        }
        return back()->withErrors([$activate_response['message']]);
    }
    
    public function update_env($data)
    {
        $envFile = app()->environmentFilePath();
        if($envFile){
            $str = file_get_contents($envFile);
            if (count($data) > 0) {
                foreach ($data as $envKey => $envValue) {
                    $keyPosition = strpos($str, "{$envKey}=");
                    $endOfLinePosition = strpos($str, "\n", $keyPosition);
                    $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                  
                    if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                        $str .= "{$envKey}={$envValue}\n";
                    } else {
                        $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                    }
            }
            }
            $str = substr($str, 0, -1);
            if (!file_put_contents($envFile, $str)){ return false;  }
            else{   return redirect('admin/settings');   }
            return Redirect::back()->withErrors(['Error check']);
        }
    }

    public function privacy()
    {
        abort_if(Gate::denies('settings_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first(['privacy_policy','terms_of_use']);
        return view('admin.policy', compact('setting'));
    }

    public function privacy_save(Request $request)
    {
        abort_if(Gate::denies('settings_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $setting = Setting::first();
        $setting->privacy_policy = $request->privacy_policy;
        $setting->terms_of_use = $request->terms_of_use;
        $setting->save();
        return redirect()->route('privacy')->withStatus(__('Privacy & Terms Settings Updated Successfully.'));
    }
}

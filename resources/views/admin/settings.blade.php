@extends('layouts.app')
@section('content_setting')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Settings')
    ])
    <div class="section-body">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{ session('status') }}
                </div>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>×</span>
                    </button>
                    {{$errors->first()}}
                </div>
            </div>
        @endif
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Settings')}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            @if ($setting->license_status == 1)
                                <!--  Verification Settings -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Verification Settings')}} </h4>
                                            <p> {{__('Verification settings like email or sms & Twilio settings')}} </p>
                                            <a data-toggle="collapse" href="#verification_settings" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/verification_settings')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="verification_settings">
                                                    <div class="form-group">
                                                        <label class="custom-switch mt-2 p-0">
                                                            <input type="checkbox" value="1" name="verification" class="custom-switch-input"
                                                                {{$setting->is_verify == 1 ? 'checked' : ''}}>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description"> {{__('Verfication(OTP)')}} </span>
                                                        </label>
                                                    </div>
                                                
                                                    <div class="col-lg-8 col-md-6 mb-3">
                                                        <div class="selectgroup w-100">
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="verification_via" value="email" class="selectgroup-input" {{$setting->verify_email == 1 ? 'checked' : ''}}>
                                                                <span class="selectgroup-button"> {{__('Via Email')}} </span>
                                                            </label>
                                                            <label class="selectgroup-item">
                                                                <input type="radio" name="verification_via" value="sms" class="selectgroup-input" {{$setting->verify_sms == 1 ? 'checked' : ''}}>
                                                                <span class="selectgroup-button"> {{__('Via SMS')}} </span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Twilio Account ID') }}</label>
                                                            <input type="text" name="twilio_acc_id" class="form-control @error('twilio_acc_id') is-invalid @enderror"
                                                                value="{{ old('twilio_acc_id',$setting->twilio_acc_id) }}" placeholder="{{__('Twilio Account ID')}}">
                                                            @error('twilio_acc_id')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Twilio Auth Token') }}</label>
                                                            <input type="text" name="twilio_auth_token" class="form-control @error('twilio_auth_token') is-invalid @enderror"
                                                                value="{{ old('twilio_auth_token',$setting->twilio_auth_token) }}" placeholder="{{ __('Twilio Auth Token') }}">
                                                            @error('twilio_auth_token')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Twilio Phone Number') }}</label>
                                                            <input type="text" name="twilio_phone_no" class="form-control @error('twilio_phone_no') is-invalid @enderror" 
                                                                value="{{ old('twilio_phone_no',$setting->twilio_phone_no) }}"placeholder="{{ __('Twilio Phone Number') }}">
                                                            @error('twilio_phone_no')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- General Settings -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('General Settings')}} </h4>
                                            <p> {{__('General settings such as, validation and so on')}} </p>
                                            <a data-toggle="collapse" href="#generalSetting" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/general_setting')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="generalSetting">
                                                    
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Application Share URL') }}</label>
                                                            <input type="text" name="share_url" class="form-control @error('share_url') is-invalid @enderror"
                                                                value="{{ old('share_url',$setting->share_url) }}" placeholder="{{ __('Application Share URL') }}" required>
                                                            @error('share_url')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Trending Challenge Minimum Views') }}</label>
                                                            <input type="number" name="trending_challenge" class="form-control @error('trending_challenge') is-invalid @enderror"
                                                                value="{{ old('trending_challenge',$setting->trending_challenge) }}" placeholder="{{ __('Trending Challenge Minimum Views') }}" required>
                                                            @error('trending_challenge')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label> {{__('Pick Your Color')}} </label>
                                                            <div class="input-group colorpickerinput colorpicker-element" data-colorpicker-id="2">
                                                                <input type="text" class="form-control" name="color" value="{{$setting->color}}">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <i class="fas fa-fill-drip"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                 
                                <!-- Video Settings -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Video Settings')}} </h4>
                                            <p> {{__('Video settings such as, auto approvel and watermark')}} </p>
                                            <a data-toggle="collapse" href="#videoSetting" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/video_setting')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="videoSetting">
                                                    <div class="form-group">
                                                        <label class="custom-switch mt-2 p-0">
                                                            <input type="checkbox" value="1" name="auto_approve" class="custom-switch-input"
                                                                {{$setting->auto_approve == 1 ? 'checked' : ''}}>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description"> {{__('Auto Approve Video')}} </span>
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <label class="custom-switch mt-2 p-0">
                                                            <input type="checkbox" value="1" name="is_watermark" class="custom-switch-input"
                                                                {{$setting->is_watermark == 1 ? 'checked' : ''}}>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description"> {{__('Watermark')}} </span>
                                                        </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="image">{{__('Watermark')}}</label>
                                                        <div class="avatar-upload avatar-box avatar-box-left">
                                                            <div class="avatar-edit">
                                                                <input type='file' id="image3" name="watermark" accept=".png, .jpg, .jpeg" />
                                                                <label for="image3"></label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                <div id="imagePreview3" style="background-image: url({{url('image/app/'.$setting->watermark)}});">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @error('watermark')
                                                            <div class="invalid-feedback display-block mt-3">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Video Quality') }}</label>
                                                            <input type="number" min="1" max="100" name="vid_qty" class="form-control @error('vid_qty') is-invalid @enderror"
                                                                value="{{ old('vid_qty',$setting->vid_qty) }}" placeholder="{{__('Video Quality')}}" required>
                                                            @error('vid_qty')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Push Notification -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-bell"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Push Notification')}} </h4>
                                            <p> {{__('Push notification settings such as, app id, app key and so on')}} </p>
                                            <a data-toggle="collapse" href="#pushNotification" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/push_notification')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="pushNotification">
                                                    <div class="form-group">
                                                        <label class="custom-switch mt-2 p-0">
                                                            <input type="checkbox" value="1" name="notification" class="custom-switch-input"
                                                                {{$setting->notification == 1 ? 'checked' : ''}}>
                                                            <span class="custom-switch-indicator"></span>
                                                            <span class="custom-switch-description"> {{__('Notification')}} </span>
                                                        </label>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('App ID') }}</label>
                                                            <input type="text" name="app_id" class="form-control @error('app_id') is-invalid @enderror"
                                                                value="{{ old('app_id',$setting->app_id) }}" placeholder="{{__('App ID')}}">
                                                            @error('app_id')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Api Key') }}</label>
                                                            <input type="text" name="api_key" class="form-control @error('api_key') is-invalid @enderror"
                                                                value="{{ old('api_key',$setting->api_key) }}" placeholder="{{ __('Api Key') }}">
                                                            @error('api_key')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Auth Key') }}</label>
                                                            <input type="text" name="auth_key" class="form-control @error('auth_key') is-invalid @enderror" 
                                                                value="{{ old('auth_key',$setting->auth_key) }}"placeholder="{{ __('Auth Key') }}">
                                                            @error('auth_key')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Project Number') }}</label>
                                                            <input type="text" name="project_number" class="form-control @error('project_number') is-invalid @enderror"
                                                                value="{{ old('project_number',$setting->project_no) }}" placeholder="{{ __('Project Number') }}">
                                                            @error('project_number')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Email Settings -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Email Settings')}} </h4>
                                            <p> {{__('Email settings settings such as, mail host, mail port and so on')}} </p>
                                            <a data-toggle="collapse" href="#emailSettings" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/email_settings')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="emailSettings">
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Mail Host') }}</label>
                                                            <input type="text" name="mail_host" class="form-control @error('mail_host') is-invalid @enderror"
                                                                value="{{ old('mail_host',$setting->mail_host) }}" placeholder="{{__('Mail Host')}}" required>
                                                            @error('mail_host')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Mail Port') }}</label>
                                                            <input type="text" name="mail_port" class="form-control @error('mail_port') is-invalid @enderror"
                                                                value="{{ old('mail_port',$setting->mail_port) }}" placeholder="{{ __('Mail Port') }}" required>
                                                            @error('mail_port')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Mail Username') }}</label>
                                                            <input type="text" name="mail_username" class="form-control @error('mail_username') is-invalid @enderror" 
                                                                value="{{ old('mail_username',$setting->mail_username) }}"placeholder="{{ __('Mail Username') }}" required>
                                                            @error('mail_username')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Mail Password') }}</label>
                                                            <input type="text" name="mail_password" class="form-control @error('mail_password') is-invalid @enderror"
                                                                value="{{ old('mail_password',$setting->mail_password) }}" placeholder="{{ __('Mail Password') }}" required>
                                                            @error('mail_password')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Sender Email') }}</label>
                                                            <input type="text" name="sender_email" class="form-control @error('sender_email') is-invalid @enderror"
                                                                value="{{ old('sender_email',$setting->sender_email) }}" placeholder="{{ __('Sender Email') }}" required>
                                                            @error('sender_email')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('Mail Encryption') }}</label>
                                                            <input type="text" name="main_encryption" class="form-control @error('main_encryption') is-invalid @enderror"
                                                                value="{{ old('main_encryption',$setting->main_encryption) }}" placeholder="{{ __('Mail Encryption') }}" required>
                                                            @error('main_encryption')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- App Information -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-mobile-alt"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('App Information')}} </h4>
                                            <p> {{__('App related information such as, name, version and so on')}} </p>
                                            <a data-toggle="collapse" href="#appInfo" class="card-cta" role="button" aria-expanded="false">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                            
                                            <form method="POST" action="{{url('/admin/settings/app_info')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                                @csrf
                                                <div class="collapse mt-3" id="appInfo">
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label for="image">{{__('Color Logo')}}</label>
                                                            <div class="avatar-upload avatar-box avatar-box-left">
                                                                <div class="avatar-edit">
                                                                    <input type='file' id="image" name="color_logo" accept=".png, .jpg, .jpeg" />
                                                                    <label for="image"></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview" style="background-image: url({{url('image/app/'.$setting->color_logo)}});">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('color_logo')
                                                                <div class="invalid-feedback display-block mt-3">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="image2">{{__('White Logo')}}</label>
                                                            <div class="avatar-upload avatar-box avatar-box-left">
                                                                <div class="avatar-edit">
                                                                    <input type='file' id="image2" name="white_logo" accept=".png, .jpg, .jpeg" />
                                                                    <label for="image2"></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview2" style="background-image: url({{url('image/app/'.$setting->white_logo)}});">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('white_logo')
                                                                <div class="invalid-feedback display-block mt-3">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label for="image4">{{__('Favicon')}}</label>
                                                            <div class="avatar-upload avatar-box avatar-box-left">
                                                                <div class="avatar-edit">
                                                                    <input type='file' id="image4" name="favicon" accept=".png, .jpg, .jpeg" />
                                                                    <label for="image4"></label>
                                                                </div>
                                                                <div class="avatar-preview">
                                                                    <div id="imagePreview4" style="background-image: url({{url('image/app/'.$setting->favicon)}});">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @error('favicon')
                                                                <div class="invalid-feedback display-block mt-3">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label>{{ __('App Name') }}</label>
                                                            <input type="text" name="app_name" class="form-control @error('app_name') is-invalid @enderror"
                                                                value="{{ old('app_name',$setting->app_name) }}" placeholder="{{__('Application Name')}}" required>
                                                            @error('app_name')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('App Version') }}</label>
                                                            <input type="text" name="app_version" class="form-control @error('app_version') is-invalid @enderror"
                                                                value="{{ old('app_version',$setting->app_version) }}" placeholder="{{ __('App Version') }}" required>
                                                            @error('app_version')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-12 col-md-12 col-lg-12 p-0">
                                                        <div class="form-group">
                                                            <label>{{ __('App Footer') }}</label>
                                                            <input type="text" name="app_footer" class="form-control @error('app_footer') is-invalid @enderror"
                                                                value="{{ old('app_footer',$setting->app_footer) }}" placeholder="{{ __('App Footer') }}" required>
                                                            @error('app_footer')
                                                                <div class="invalid-feedback display-block">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-right">
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Admin Language -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-language"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Admin Languages')}} </h4>
                                            <p> {{__('Language related information such as, name, direction and so on')}} </p>
                                            <a href="{{url('/admin/settings/language')}}" class="card-cta">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Advertisement  Language -->
                                <div class="col-lg-6">
                                    <div class="card card-large-icons">
                                        <div class="card-icon bg-primary text-white">
                                            <i class="fas fa-ad"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4> {{__('Advertisement')}} </h4>
                                            <p> {{__('Advertisement related information such as, AdMob, Facebook')}} </p>
                                            <a href="{{url('/admin/settings/advertisement')}}" class="card-cta">
                                                {{__('Change Setting')}} <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- License -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('License')}} </h4>
                                        <p> {{__('Activate license by key & client name')}} </p>
                                        <a data-toggle="collapse" href="#license" class="card-cta" role="button" aria-expanded="true">
                                            {{__('View Setting')}} <i class="fas fa-chevron-right"></i>
                                        </a>

                                        <form method="POST" action="{{url('/admin/settings/license')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                                            @csrf
                                            <div class="collapse mt-3" id="license">
                                                <div class="col-12 col-md-12 col-lg-12 p-0">
                                                    <div class="form-group">
                                                        <label>{{ __('License Key') }}</label>
                                                        <input type="text" name="license_key" class="form-control @error('license_key') is-invalid @enderror"
                                                            value="{{ old('license_key',$setting->license_code) }}" placeholder="{{ __('License Key') }}" required {{$setting->license_status == 1?'disabled':''}}>
                                                        @error('license_key')
                                                            <div class="invalid-feedback display-block">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-12 col-md-12 col-lg-12 p-0">
                                                    <div class="form-group">
                                                        <label>{{ __('Client Name') }}</label>
                                                        <input type="text" name="license_client_name" class="form-control @error('license_client_name') is-invalid @enderror"
                                                            value="{{ old('license_client_name',$setting->license_client_name) }}" placeholder="{{ __('Client Name') }}" required  {{$setting->license_status == 1?'disabled':''}}>
                                                        @error('license_client_name')
                                                            <div class="invalid-feedback display-block">
                                                                {{$message}}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="card-footer text-right">
                                                    @if ($setting->license_status == 0)
                                                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
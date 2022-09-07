@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Advertisement Keys'),
            'headerData' => __('Settings'),
            'url' => 'admin/settings'
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
        
      
        <div class="card">
            <div class="card-header">
                <h4> {{__("AdMob")}} </h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('/admin/settings/admob-update')}}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label class="custom-switch mt-2 p-0">
                            <input type="checkbox" name="admob" value="1" class="custom-switch-input" {{$setting->admob == 1 ? 'checked' : ''}}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> {{__('AdMob')}}</span>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            
                            <div class="form-group">
                                <label> {{__("AdMob app ID - Android")}} </label>
                                <input type="text" name="android_admob_app_id" value="{{ old('android_admob_app_id',$setting->android_admob_app_id) }}" class="form-control">
                                @error('android_admob_app_id')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Banner - Android")}} </label>
                                <input type="text" name="android_banner" value="{{ old('android_banner',$setting->android_banner) }}" class="form-control">
                                @error('android_banner')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Interstitial - Android")}} </label>
                                <input type="text" name="android_interstitial" value="{{ old('android_interstitial',$setting->android_interstitial) }}" class="form-control">
                                @error('android_interstitial')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Native - Android")}} </label>
                                <input type="text" name="android_native" value="{{ old('android_native',$setting->android_native) }}" class="form-control">
                                @error('android_native')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label> {{__("AdMob app ID - IOS")}} </label>
                                <input type="text" name="ios_admob_app_id" value="{{ old('ios_admob_app_id',$setting->ios_admob_app_id) }}" class="form-control">
                                @error('ios_admob_app_id')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Banner - IOS")}} </label>
                                <input type="text" name="ios_banner" value="{{ old('ios_banner',$setting->ios_banner) }}" class="form-control">
                                @error('ios_banner')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Interstitial - IOS")}} </label>
                                <input type="text" name="ios_interstitial" value="{{ old('ios_interstitial',$setting->ios_interstitial) }}" class="form-control">
                                @error('ios_interstitial')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> {{__("Native - IOS")}} </label>
                                <input type="text" name="ios_native" value="{{ old('ios_native',$setting->ios_native) }}" class="form-control">
                                @error('ios_native')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4> {{__("Facebook")}} </h4>
                    </div>
                    <div class="form-group">
                        <label class="custom-switch mt-2 p-0">
                            <input type="checkbox" name="facebook" value="1" class="custom-switch-input" {{$setting->facebook == 1 ? 'checked' : ''}}>
                            <span class="custom-switch-indicator"></span>
                            <span class="custom-switch-description"> {{__('Facebook')}}</span>
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label> {{__("Init Key")}} </label>
                                <input type="text" name="facebook_init" value="{{ old('facebook_init',$setting->facebook_init) }}" class="form-control">
                                @error('facebook_init')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div class="form-group">
                                <label> {{__("Banner")}} </label>
                                <input type="text" name="facebook_banner" value="{{ old('facebook_banner',$setting->facebook_banner) }}" class="form-control">
                                @error('facebook_banner')
                                    <div class="invalid-feedback display-block">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
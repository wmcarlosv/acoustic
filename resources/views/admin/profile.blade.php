@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Profile')
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
                        <h4> {{__('Edit Profile')}} </h4>
                        
                    </div>
                    
                    <form method="POST" action="{{url('/admin/profile/'.$user->id)}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                            <div class="card-body">
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('Cover Image')}} </label>
                                    <div class="avatar-upload avatar-box avatar-box-left col-sm-12 col-md-7">
                                        <div class="avatar-edit">
                                            <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg"/>
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url({{url('image/user/'.$user->image)}});">
                                            </div>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback display-block mt-3">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('Name')}} </label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name',$user->name)}}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('Email')}} </label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email',$user->email)}}" required>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit"> {{__('Save Changes')}} </button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Change Password')}} </h4>
                        
                    </div>
                    
                    <form method="POST" action="{{url('/admin/profile/changepassword/'.$user->id)}}" class="needs-validation" novalidate="">
                        @csrf
                            <div class="card-body">
                                
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('Current Password')}} </label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">
                                        @error('current_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('New Password')}} </label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password">
                                        @error('new_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"> {{__('Confirm Password')}} </label>
                                    <div class="col-sm-12 col-md-7">
                                        <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
                                        @error('confirm_password')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                    <div class="col-sm-12 col-md-7">
                                        <button class="btn btn-primary" type="submit"> {{__('Change Password')}} </button>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
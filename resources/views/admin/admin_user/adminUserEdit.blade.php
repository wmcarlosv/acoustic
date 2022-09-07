@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Admin User'),
            'headerData' => __('Admin Users'),
            'url' => 'admin/admin-user'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Admin User')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/admin-user/'.$user->id)}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-4 webkit-center">
                                    <label for="image">{{__('Image')}}</label>
                                    <div class="avatar-upload avatar-box avatar-box-left">
                                        <div class="avatar-edit">
                                            <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
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
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Name')}} </label>
                                        <input type="text" name="name"  value="{{ old('name',$user->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Admin User Name')}}" required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
    
                                    <div class="form-group">
                                        <label> {{__('Email')}} </label>
                                        <input type="text" name="email" value="{{ old('email',$user->email) }}"  class="form-control @error('email') is-invalid @enderror" placeholder="{{__('Admin User Email')}}" disabled>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Roles')}} </label>
                                        <select name="roles[]" class="form-control select2 select2_multi_roles @error('roles') is-invalid @enderror" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}"  multiple="multiple">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}" {{ (collect(old('roles'))->contains($role->id)) ? 'selected':'' }}
                                                    {{ $user->roles->contains($role->id) == 1 ? 'selected' : '' }}>
                                                    {{$role->name}} </option>
                                            @endforeach
                                        </select>
                                        @error('roles')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
    
                                    @if (!$user->hasRole('Admin'))
                                        <div class="form-group">
                                            <label> {{__('Status')}} </label>
                                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                                <option value="1" {{(old('status', $user->status) == "1")? 'selected':''}}> {{__('Active')}} </option>
                                                <option value="0" {{(old('status', $user->status) == "0")? 'selected':''}}> {{__('Inactive')}} </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit"> {{__('Submit')}} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Users')
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
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('All Users')}} </h4>
                        
                    </div>
                    <div class="card-body">
                        
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('User')}} </th>
                                        <th> {{__('Login')}} </th>
                                        <th> {{__('Account')}} </th>
                                        <th> {{__('Status')}} </th>
                                        <th> {{__('Action')}} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td>
                                                <div class="media">
                                                    <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$user->image) }}">
                                                    <div class="media-body">
                                                        <div class="media-title mb-0">
                                                            {{ $user->name }}
                                                        </div>
                                                        <div class="media-description text-muted"> {{$user->user_id }} </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <i class="fab fa-google provider {{ $user->provider == "google"? 'text-google':'text-muted' }}"></i>
                                                <i class="fab fab fa-facebook-f provider {{ $user->provider == "facebook"? 'text-facebook':'text-muted' }}"></i>
                                                <i class="fab fa-apple provider {{ $user->provider == "apple"? 'text-black':'text-muted' }}"></i>
                                                <i class="fas fa-at provider {{ $user->provider == "local"? 'text-warning':'text-muted' }}"></i>
                                            </td>
                                            
                                            <td>
                                                @if ($user->follower_request == 1)
                                                    <h6> <span class="badge badge-danger"> Private </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-success"> Public </span> </h6>
                                                @endif
                                            </td>
                                            <td>
                                                @cannot('app_user_edit')
                                                    @if ($user->status == 1)
                                                        <h6> <span class="badge badge-success"> Active </span> </h6>
                                                    @else
                                                        <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                    @endif
                                                @endcannot
                                                @can('app_user_edit')
                                                    <label class="cursor-pointer">
                                                        <input type="checkbox" name="custom-switch-checkbox" onchange="change_status({{$user->id}},'user/status')" class="custom-switch-input" {{$user->status == 1? 'checked': ''}}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('app_user_access')
                                                    <a href="{{ url('admin/user/'.$user->id) }}" class="btn-warning btn">
                                                        <i class="far fa-eye action_icon"></i>
                                                    </a>
                                                @endcan
                                                @can('app_user_delete')
                                                    <button class="btn-danger btn" onclick="all_delete('admin/user',{{$user->id}})">
                                                        <i class="fas fa-trash action_icon"></i>
                                                    </button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
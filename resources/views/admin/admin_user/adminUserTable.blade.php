@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Admin Users')
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
                        <h4> {{__('All Admin Users')}} </h4>
                        @can('admin_user_create')
                            <a href="{{ url('/admin/admin-user/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                    <div class="card-body">
                       
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Name')}} </th>
                                        <th> {{__('Email')}} </th>
                                        <th> {{__('Role')}} </th>
                                        <th> {{__('Status')}} </th>
                                        @if (Gate::check('admin_user_edit'))
                                            <th> {{__('Action')}} </th>
                                        @endif
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
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{$user->email}} </td>
                                            
                                            <td>
                                                <div class="badges">
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <div class="badge badge-secondary"> {{$role}} </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            
                                            <td>
                                                @if ($user->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
                                            </td>
                                            
                                            @if (Gate::check('admin_user_edit'))
                                                <td>
                                                    @if (!$user->hasRole('Super Admin'))
                                                        @can('admin_user_edit')
                                                            <a href="{{ url('admin/admin-user/'.$user->id.'/edit') }}" class="btn btn-info mb-2">
                                                                <i class="far fa-edit action_icon"></i>
                                                            </a>
                                                        @endcan
                                                    @endif
                                                </td>
                                            @endif
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
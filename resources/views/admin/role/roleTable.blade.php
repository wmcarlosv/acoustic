@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Roles')
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
                        <h4> {{__('All Roles')}} </h4>
                        @can('role_create')
                            <a href="{{ url('/admin/role/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
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
                                        <th> {{__('Permissions')}} </th>
                                        @if (Gate::check('role_edit') || Gate::check('role_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{$role->name}} </td>
                                            <td class="w-75">
                                                <div class="badges">
                                                    @if($role->name == "Super Admin")
                                                        <div class="badge badge-secondary"> All </div>
                                                    @else
                                                        @foreach ($role->permissions as $per)
                                                            <div class="badge badge-secondary"> {{$per->name}} </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            @if (Gate::check('role_edit') || Gate::check('role_delete'))
                                                <td>
                                                    @if($role->name != "Super Admin")
                                                        @can('role_edit')
                                                            <a href="{{ url('admin/role/'.$role->id.'/edit') }}" class="btn btn-info">
                                                                <i class="far fa-edit action_icon"></i>
                                                            </a>
                                                        @endcan
                                                        @can('role_delete')
                                                            <button class="btn-danger btn" onclick="all_delete('admin/role',{{$role->id}})">
                                                                <i class="fas fa-trash action_icon"></i>
                                                            </button>
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
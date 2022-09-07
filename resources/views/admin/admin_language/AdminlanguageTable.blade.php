@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Admin Languages'),
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
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('All Admin Languages')}} </h4>
                        @can('admin_language_create')
                            <a href="{{ url('/admin/settings/language/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        
                       @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Image')}} </th>
                                        <th> {{__('Name')}} </th>
                                        <th> {{__('Direction')}} </th>
                                        <th> {{__('Status')}} </th>
                                        @if (Gate::check('admin_language_delete') && Gate::check('admin_language_edit'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($languages as $language)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            
                                            <td> 
                                                <span class="avatar1">
                                                    <img class="small_round flag_table" src="{{ asset('image/app/' . $language->image) }}">
                                                </span>    
                                            </td>
                                            <td> {{$language->name}} </td>
                                            <td>
                                                @if ($language->direction == "rtl")
                                                    <h6> <span class="badge badge-success"> RTL </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-success"> LTR </span> </h6>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($language->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
                                            </td>
                                            @if (Gate::check('admin_language_delete') && Gate::check('admin_language_edit'))
                                                <td>
                                                    @can('admin_language_edit')
                                                        <a href="{{ url('admin/settings/language/'.$language->id.'/edit') }}" class="btn btn-info">
                                                            <i class="far fa-edit action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('admin_language_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/settings/language',{{$language->id}})">
                                                            <i class="fas fa-trash action_icon"></i>
                                                        </button>
                                                    @endcan
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
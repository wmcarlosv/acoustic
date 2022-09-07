@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Advertisements')
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
                        <h4> {{__('All Advertisements')}} </h4>
                        @can('advertisement_create')
                            <a href="{{ url('/admin/advertisements/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                    <div class="card-body">
                       
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Location')}} </th>
                                        <th> {{__('Network')}} </th>
                                        <th> {{__('Type')}} </th>
                                        <th> {{__('Interval')}} </th>
                                        <th> {{__('Status')}} </th>
                                        @if (Gate::check('advertisement_edit') || Gate::check('advertisement_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($advertisements as $ad)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{$ad->location}} </td>
                                            <td> {{$ad->network}} </td>
                                            <td> {{$ad->type}} </td>
                                            <td> {{$ad->interval}} </td>
                                            <td>
                                                @if ($ad->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
                                            </td>
                                            
                                            @if (Gate::check('advertisement_edit') || Gate::check('advertisement_delete'))
                                                <td>
                                                    @can('advertisement_edit')
                                                        <a href="{{ url('admin/advertisements/'.$ad->id.'/edit') }}" class="btn btn-info">
                                                            <i class="far fa-edit action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('advertisement_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/advertisements',{{$ad->id}})">
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
@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Challenges')
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
                        <h4> {{__('All Challenges')}} </h4>
                        @can('challenge_create')
                            <a href="{{ url('/admin/challenge/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
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
                                        <th> {{__('Title')}} </th>
                                        <th> {{__('Description')}} </th>
                                        <th> {{__('Videos')}} </th>
                                        <th> {{__('Status')}} </th>
                                        @if (Gate::check('challenge_edit') || Gate::check('challenge_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($challenges as $challenge)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td class="lightBox-banner">
                                                <a href="{{ url('/image/challenge/'.$challenge->image) }}" title="{{ $challenge->title }}">
                                                    <img src="{{ url('/image/challenge/'.$challenge->image) }}" class="border-radius-10" height="70" width="120" >
                                                </a>
                                            </td>
                                            <td> {{$challenge->title}} </td>
                                            <td> {{$challenge->desc}} </td>
                                            <td> {{$challenge->challengeUsed}} </td>
                                            <td>
                                                @if ($challenge->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
                                            </td>
                                            
                                            @if (Gate::check('challenge_edit') || Gate::check('challenge_delete'))
                                                <td>
                                                    @can('challenge_edit')
                                                        <a href="{{ url('admin/challenge/'.$challenge->id.'/edit') }}" class="btn btn-info">
                                                            <i class="far fa-edit action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('challenge_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/challenge',{{$challenge->id}})">
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
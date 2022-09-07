@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Languages')
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
                        <h4> {{__('All Languages')}} </h4>
                        @can('language_create')
                            <a href="{{ url('/admin/language/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row sortable-card" id="sortable-card-language">
            @foreach ($languages as $language)
                <div class="col-12 col-md-6 col-lg-3 mb-2">
                    <div class="card card-primary">
                        <div class="card-header  d-felx justify-content-between">
                            <h4> {{$language->name}} </h4>
                            @if ($language->status == 1)
                                <h6> <span class="badge badge-success"> Active </span> </h6>
                            @else
                                <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                            @endif
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <p> <strong>  {{__('Songs :')}} </strong> {{$language->songCount}}</p>
                                </div>
                                <div class="col-6">
                                    <p> <strong> {{__('Videos :')}} </strong> {{$language->videoCount}}</p>
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer text-right">
                            @can('language_edit')
                                <a href="{{ url('admin/language/'.$language->id.'/edit') }}" class="btn btn-info">
                                    <i class="far fa-edit action_icon"></i>
                                </a>
                            @endcan
                            @can('language_delete')
                                <button class="btn-danger btn" onclick="all_delete('admin/language',{{$language->id}})">
                                    <i class="fas fa-trash action_icon"></i>
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
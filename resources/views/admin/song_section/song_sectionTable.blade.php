@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Song Sections')
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
                        <h4> {{__('All Song Sections')}} </h4>
                        @can('song_section_create')
                            <a href="{{ url('/admin/song_section/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        @if (count($song_sections) == 0)
        <div class="row">
            <div class="col-12 text-center">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="far fa-list-alt"></i>
                    </div>
                    <h2> {{__('There are no song sections.')}} </h2>
                </div>
            </div>
        </div>
        @else
            <div class="row sortable-card" id="sortable-card-song-section">
                @foreach ($song_sections as $song_section)
                    <div class="col-12 col-md-12 col-lg-4 mb-2">
                        <div class="card card-primary">
                            <div class="card-header py-4">
                                <div class="media w-100">
                                    <img class="mr-3" height="120" width="120" src="{{ url('/image/song_section/'.$song_section->image) }}">
                                    <div class="media-body">
                                        <h5 class="mt-0"> {{$song_section->title}} </h5>
                                        <p class="mb-0"> <strong> {{__('Songs :')}} </strong> {{$song_section->songCount}} </p>
                                        @if ($song_section->status == 1)
                                            <h6> <span class="badge badge-success"> Active </span> </h6>
                                        @else
                                            <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                        @endif
                                        <div class="text-right">
                                            @can('song_section_edit')
                                                <a href="{{ url('admin/song_section/'.$song_section->id.'/edit') }}" class="btn btn-info">
                                                    <i class="far fa-edit action_icon"></i>
                                                </a>
                                            @endcan
                                            @can('song_section_delete')
                                                <button class="btn-danger btn" onclick="all_delete('admin/song_section',{{$song_section->id}})">
                                                    <i class="fas fa-trash action_icon"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        

    </div>
</section>
@endsection
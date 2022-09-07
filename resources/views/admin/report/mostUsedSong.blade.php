@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Most Used Song'),
            'headerData' => __('Report'),
            'url' => 'admin/report'
    ])
    @include('layouts.filter',[
        'url' => 'admin/report/most-used-song'
    ])

    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Top 50 Most Used Songs')}} </h4>
                    </div>
                    <div class="card-body">
                        
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Song')}} </th>
                                        <th> {{__('Audio')}} </th>
                                        <th> {{__('Videos')}} </th>
                                        <th> {{__('Language')}} </th>
                                        <th> {{__('Status')}} </th>
                                        @if (Gate::check('song_edit') || Gate::check('song_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($songs as $song)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td class="lightBox-banner">
                                                <div class="media">
                                                    <a href="{{ url('/image/song/'.$song->image) }}" title="{{ $song->title }}">
                                                        <img alt="image" class="mr-3 border-radius-10"  height="65" width="100" src="{{ url('/image/song/'.$song->image) }}">
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="media-title mb-0">
                                                            {{ $song->title }}
                                                        </div>
                                                        <div class="media-description text-muted">
                                                            {{$song->artist }}
                                                            @if($song->movie != null)
                                                                - {{$song->movie}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                                
                                            <td> <a href="{{url('/image/song/'.$song->audio)}}" target="_blank"> {{$song->audio}} </a> </td>
                                            <td> {{$song->use_count}} </td>
                                            <td> {{$song->lang}} </td>
                                            <td>
                                                @if ($song->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
                                            </td>
                                            
                                            @if (Gate::check('song_edit') || Gate::check('song_delete'))
                                                <td>
                                                    @can('song_edit')
                                                        <a href="{{ url('admin/songs/'.$song->id.'/edit') }}" class="btn btn-info">
                                                            <i class="far fa-edit action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('song_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/songs',{{$song->id}})">
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
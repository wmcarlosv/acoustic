@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Most Used Audio'),
            'headerData' => __('Report'),
            'url' => 'admin/report'
    ])
    @include('layouts.filter',[
        'url' => 'admin/report/most-used-audio'
    ])

    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Top 50 Most Used Audios')}} </h4>
                    </div>
                    <div class="card-body">
                        
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Original Audio')}} </th>
                                        <th> {{__('Original Video')}} </th>
                                        <th> {{__('Audio')}} </th>
                                        <th> {{__('Videos')}} </th>
                                        <th> {{__('Language')}} </th>
                                        <th> {{__('Status')}} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audios as $audio)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            
                                            <td>
                                                <a href="{{ url('/admin/user/'.$audio->user->id) }}">
                                                    <div class="media">
                                                        <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$audio->user->image) }}">
                                                        <div class="media-body">
                                                            <div class="media-title mb-0">
                                                                {{ $audio->user->name }}
                                                            </div>
                                                            <div class="media-description text-muted"> {{$audio->user->user_id}} </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/video/'.$audio->video->id) }}">
                                                    <img  src="{{ url('/image/video/'.$audio->video->screenshot) }}" class="border-radius-10" height="50" width="50" >
                                                </a>
                                            </td>
                                                
                                            <td> <a href="{{url('/image/user_audio/'.$audio->audio)}}" target="_blank"> {{$audio->audio}} </a> </td>
                                            <td> {{$audio->use_count}} </td>
                                            <td> {{$audio->lang}} </td>
                                            <td>
                                                @if ($audio->status == 1)
                                                    <h6> <span class="badge badge-success"> Active </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> Inactive </span> </h6>
                                                @endif
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
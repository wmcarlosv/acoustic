@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Unapproved Videos')
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
                        <h4> {{__('All Unapproved Videos')}} </h4>
                    </div>
                    <div class="card-body">
                       
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('User')}} </th>
                                        <th> {{__('Video')}} </th>
                                        <th> {{__('Privacy')}} </th>
                                        <th> {{__('Views')}} </th>
                                        <th> {{__('Likes')}} </th>
                                        <th> {{__('Comments')}} </th>
                                        <th> {{__('Approved')}} </th>
                                        <th> {{__('Created At')}} </th>
                                        @if (Gate::check('video_edit') || Gate::check('video_access')|| Gate::check('video_delete') )
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($videos as $video)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            
                                            <td>
                                                <a href="{{ url('/admin/user/'.$video->user->id) }}">
                                                    <div class="media">
                                                        <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$video->user->image) }}">
                                                        <div class="media-body">
                                                            <div class="media-title mb-0">
                                                                {{ $video->user->name }}
                                                            </div>
                                                            <div class="media-description text-muted"> {{$video->user->user_id }} </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('/admin/video/'.$video->id) }}">
                                                    <img src="{{ url('/image/video/'.$video->screenshot) }}" class="border-radius-10" height="50" width="50" >
                                                </a>
                                            </td>
                                            
                                            <td>
                                                <h6> <span class="badge badge-success"> {{$video->view}} </span> </h6>
                                            </td>
                                            <td> {{$video->viewCount}} </td>
                                            <td> {{$video->likeCount}} </td>
                                            <td> {{$video->commentCount}} </td>
                                            <td>
                                                @cannot('video_edit')
                                                    @if ($video->is_approved == 1)
                                                        <h6> <span class="badge badge-success"> Approved </span> </h6>
                                                    @else
                                                        <h6> <span class="badge badge-danger"> Not Approved </span> </h6>
                                                    @endif
                                                @endcannot
                                                @can('video_edit')
                                                    <label class="cursor-pointer">
                                                        <input type="checkbox" name="custom-switch-checkbox" onchange="approve_video({{$video->id}})" class="custom-switch-input" {{$video->is_approved == 1? 'checked': ''}}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                @endcan
                                            </td>
                                            <td> {{$video->created_at}} </td>
                                            
                                            
                                            @if (Gate::check('video_edit') || Gate::check('video_access')|| Gate::check('video_delete') )
                                                <td>
                                                    @can('video_access')
                                                        <a href="{{ url('admin/video/'.$video->id) }}" class="btn btn-warning">
                                                            <i class="far fa-eye action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('video_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/video',{{$video->id}})">
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
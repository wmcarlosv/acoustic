@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('All Videos'),
            'headerData' => __('Videos'),
            'url' => 'admin/video'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <h2 class="section-title"> {{ $user->user_id }} </h2>
                    <p class="section-lead">
                        {{ $user->name }}
                    </p>
                    <div class="row mt-sm-4">
                        <div class="col-12 col-md-12 col-lg-4">
                            @include('admin.include_profile')
                        </div>
                        <div class="col-12 col-md-12 col-lg-8 posts">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="wrap">
                                        <div class="box-video">
                                            <div class="bg-video" style="background-image: url({{asset('image/video/'.$video->screenshot)}});">
                                                <div class="bt-play">Play</div>
                                            </div>
                                            <div class="video-container">
                                                <iframe width="590" height="332" src="{{ url('/image/video/'.$video->video) }}"></iframe>
                                            </div>
                                        </div>
                                        <div class="media mb-4">
                                            <div class="media-title">
                                                {{$video->viewCount}} {{__('Views')}}
                                                <div class="heart mr-2"> {{$video->likeCount}} <i class="fa fa-heart text-danger"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            {{$video->description}}
                                        </div>
                                        
                                        <div class="badges">
                                              
                                            @if ($video->is_approved == 1)
                                                <span class="badge badge-gray"> {{__('Approved')}} </span>
                                            @else
                                                <span class="badge badge-danger"> {{__('Disapproved')}} </span>
                                            @endif

                                            @if ($video->view == "public")
                                                <span class="badge badge-gray"> {{__('Public')}} </span>
                                            @elseif($video->view == "followers")
                                                <span class="badge badge-gray"> {{__('Followers')}} </span>
                                            @elseif($video->view == "private")
                                                <span class="badge badge-gray"> {{__('Private')}} </span>
                                            @endif

                                            <span class="badge badge-gray"> {{$video->language}} </span>
                                            
                                            @if ($video->is_comment == 0)
                                                <span class="badge badge-danger"> {{__('Not Commentable')}} </span>
                                            @endif
                                            
                                            @if ($video->report > 0)
                                                @if ($video->report >= 1 && $video->report < 10)
                                                    <span class="badge badge-gray"> {{__('Report Video :')}} {{$video->report}} {{__('Times')}} </span>
                                                @else
                                                    <span class="badge badge-danger"> {{__('Report Video :')}} {{$video->report}} {{__('Times')}} </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4> {{__('Comments')}} ({{count($comments)}}) </h4>
                                        </div>
                                        @if (count($comments) == 0)
                                            <div class="empty-state">
                                                <div class="empty-state-icon">
                                                    <i class="fas fa-comment"></i>
                                                </div>
                                                <h2> {{__('There are no comments.')}} </h2>
                                            </div>
                                        @else
                                            <div class="card-body scrollbar" id="style-3">
                                                <ul class="list-unstyled list-unstyled-border list-unstyled-noborder force-overflow">
                                                    @foreach ($comments as $comment)
                                                        <li class="media">
                                                            <img alt="image" class="mr-3 rounded-circle" width="40" src="{{ url('/image/user/'.$comment->user->image) }}">
                                                            <div class="media-body">
                                                                <div class="media-right mr-3"> <i class="fa fa-heart text-danger" aria-hidden="true"></i> {{ $comment->likesCount }} </div>
                                                                <div class="media-title mb-1">
                                                                    <a href="{{ url('/admin/user/'.$user->id) }}" class="color-primary">
                                                                        {{ $comment->user->name }}
                                                                    </a>
                                                                    <div class="bullet"></div>
                                                                    {{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                                                </div>
                                                                <div class="media-description text-muted"> {{ $comment->comment }} </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('All Users'),
            'headerData' => __('Users'),
            'url' => 'admin/user'
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
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts_tab" role="tab" aria-controls="posts" aria-selected="true"> <i class="fa fa-play mr-2"></i> {{__('Posts')}} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="saved-tab" data-toggle="tab" href="#saved_tab" role="tab" aria-controls="saved" aria-selected="false"> <i class="fa fa-bookmark mr-2"></i> {{__('Saved')}} </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="liked-tab" data-toggle="tab" href="#liked_tab" role="tab" aria-controls="liked" aria-selected="false"> <i class="fa fa-heart mr-2"></i> {{__('Liked')}} </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="posts_tab" role="tabpanel" aria-labelledby="posts-tab">
                                            <div class="card-body">
                                                <div class="post post-md">
                                                    <div class="row">
                                                        @if (count($posts) == 0)
                                                            <div class="empty-state col-12">
                                                                <div class="empty-state-icon">
                                                                    <i class="fa fa-play"></i>
                                                                </div>
                                                                <h2> {{__('There are no post.')}} </h2>
                                                            </div>
                                                        @else
                                                            @foreach ($posts as $post)
                                                                <div class="col-sm-6 col-md-4 col-lg-3">
                                                                    <a href=" {{url('/admin/video/'.$post->id)}} ">
                                                                        <article class="article">
                                                                            <div class="article-header border-radius-8">
                                                                                <div class="article-image" data-background="{{ url('/image/video/'.$post->screenshot) }}"></div>
                                                                                <div class="article-title">
                                                                                    {{$post->viewCount}} {{__('Views')}}
                                                                                    <span> </span> 
                                                                                    <div class="heart mr-2"> {{$post->likeCount}} <i class="fas fa-heart text-danger"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="saved_tab" role="tabpanel" aria-labelledby="saved-tab">
                                            
                                            <div class="card-body">
                                                <div class="post post-md">
                                                    <div class="row">
                                                        @if (count($saved) == 0)
                                                            <div class="empty-state col-12">
                                                                <div class="empty-state-icon">
                                                                    <i class="fa fa-bookmark"></i>
                                                                </div>
                                                                <h2> {{__('There are no saved post.')}} </h2>
                                                            </div>
                                                        @else
                                                            @foreach ($saved as $post)
                                                                <div class="col-sm-6 col-md-4 col-lg-3">
                                                                    <a href=" {{url('/admin/video/'.$post->video->id)}} ">
                                                                        <article class="article">
                                                                            <div class="article-header border-radius-8">
                                                                                <div class="article-image" data-background="{{ url('/image/video/'.$post->video->screenshot) }}"></div>
                                                                                <div class="article-title">
                                                                                    {{$post->video->viewCount}} {{__('Views')}}
                                                                                    <span> </span> 
                                                                                    <div class="heart mr-2"> {{$post->video->likeCount}} <i class="fa fa-heart text-danger"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="tab-pane fade" id="liked_tab" role="tabpanel" aria-labelledby="liked-tab">
                                            
                                            <div class="card-body">
                                                <div class="post post-md">
                                                    <div class="row">
                                                        
                                                        @if (count($saved) == 0)
                                                            <div class="empty-state col-12">
                                                                <div class="empty-state-icon">
                                                                    <i class="fa fa-heart"></i>
                                                                </div>
                                                                <h2> {{__('There are no liked post.')}} </h2>
                                                            </div>
                                                        @else
                                                            @foreach ($liked as $post)
                                                                <div class="col-sm-6 col-md-4 col-lg-3">
                                                                    <a href=" {{url('/admin/video/'.$post->video->id)}} ">
                                                                        <article class="article">
                                                                            <div class="article-header border-radius-8">
                                                                                <div class="article-image" data-background="{{ url('/image/video/'.$post->video->screenshot) }}"></div>
                                                                                <div class="article-title">
                                                                                    {{$post->video->viewCount}} {{__('Views')}}
                                                                                    <span> </span> 
                                                                                    <div class="heart mr-2"> {{$post->video->likeCount}} <i class="fas fa-heart text-danger"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                    </a>
                                                                </div>
                                                            @endforeach
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
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
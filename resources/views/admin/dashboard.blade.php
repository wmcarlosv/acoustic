@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Dashboard')
    ])
        
    <div class="section-body">
        
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4> {{__('Total Users')}} </h4>
                        </div>
                        <div class="card-body">
                            {{$user_count}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4> {{__('Total Video')}} </h4>
                        </div>
                        <div class="card-body">
                            {{$video_count}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4> {{__('Total Challenges')}} </h4>
                        </div>
                        <div class="card-body">
                            {{$challenge_count}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-music"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4> {{__('Total Songs')}} </h4>
                        </div>
                        <div class="card-body">
                            {{$song_count}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- chart --}}
            <div class="col-lg-8 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary"> {{__('Users')}} </h5>
                        <p class="card-text mb-3"> {{__('Registered in last 7 days.')}} </p>
                        <canvas id="myChart" height="129"></canvas>
                    </div>
                </div>
            </div>
            
            {{-- Customers need help --}}
            <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                <div class="card card-hero">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="far fa-question-circle"></i>
                        </div>
                        <h4> {{$problem_count}} </h4>
                        <div class="card-description"> {{__('Users need help')}} </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @if (count($problems) == 0)
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-question"></i>
                                    </div>
                                    <h2> {{__('No problem reported.')}} </h2>
                                </div>
                            @else
                                @foreach ($problems as $item)
                                    <div class="ticket-item">
                                        <div class="ticket-title text-primary">
                                            <h4> {{$item->subject}} </h4>
                                        </div>
                                        <div class="ticket-info">
                                            <div> {{$item->userName}} </div>
                                            <div class="bullet"></div>
                                            <div> {{$item->createTime}} </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            
                            @can('user_problem_access')
                                <a href="{{ url('/admin/problem_report') }}" class="ticket-item ticket-more">
                                    {{__('View All')}} <i class="fas fa-chevron-right"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Platform donut chart --}}
            <div class="col-lg-5 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary"> {{__('Platforms')}} </h5>
                        <p class="card-text"> {{__('Platform diversity among users.')}} </p>

                        <canvas id="myChart3"></canvas>
                    </div>
                </div>
            </div>
             
            {{-- Challenges --}}
            <div class="col-lg-7 col-sm-12 col-md-12">
                <div class="card pb-3">
                    <div class="card-header ">
                        <h5 class="card-title text-primary">{{__('Challenges')}}</h5>
                        <div class="card-header-action {{ session()->has('direction')&& session('direction') == 'rtl'? ' mr-auto':' ml-auto'}}">
                            @can('challenge_access')
                                <a href="{{ url('/admin/challenge') }}" class="btn btn-primary"> {{__('View All')}} </a>
                            @endcan
                        </div>
                      </div>
                    <div class="card-body">
                        @if (count($challenges) == 0)
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-hashtag"></i>
                                </div>
                                <h2> {{__('There are no challenges.')}} </h2>
                            </div>
                        @else
                            <div class="owl-carousel owl-theme" id="challenges-carousel">
                                @foreach ($challenges as $item)
                                    <div class="product-item pb-3">
                                        <div class="product-image">
                                            <img alt="image" src="{{ url('/image/challenge/'.$item->image) }}" class="img-fluid">
                                        </div>
                                        <div class="product-details">
                                            <div class="product-name"> {{$item->title}} </div>
                                            <div class="text-muted text-small px-4"> {{ substr($item->desc,0,70)}} {{ strlen($item->desc) > 70 ? '...' : ""}} </div>
                                            <div class="text-primary mt-2"> {{$item->challengeUsed}} {{__('Times')}} </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary"> {{__('Users')}} </h5>
                            <p class="card-text"> {{__('Below are the number of registrations shown comparatively.')}} </p>
                        </div>
                        <div class="table-responsive dashboard">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th id="user_text_curr"> {{__('Today')}} </th>
                                        <td id="user_count_curr"> {{$today_users}} </td>
                                    </tr>
                                    <tr>
                                        <th id="user_text_past"> {{__('Yesterday')}} </th>
                                        <td id="user_count_past"> {{$yesterday_users}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body border-top text-center mt-3">
                            <div class="btn-group btn-group-md py-2 user_statistics" role="group">
                                <button type="button" id="btn-h" class="btn btn-outline-primary" onclick="user_dashboard('h')"> 1H </button>
                                <button type="button" id="btn-d" class="btn btn-outline-primary border-radius-0 bg-primary text-white" onclick="user_dashboard('d')"> 1D </button>
                                <button type="button" id="btn-w" class="btn btn-outline-primary border-radius-0" onclick="user_dashboard('w')"> 1W </button>
                                <button type="button" id="btn-m" class="btn btn-outline-primary" onclick="user_dashboard('m')"> 1M </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="mb-3 mb-lg-0">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-primary"> {{__('Videos')}} </h5>
                            <p class="card-text"> {{__('Below are the number of videos uploads shown comparatively.')}} </p>
                        </div>
                        <div class="table-responsive dashboard">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <th id="video_text_curr"> {{__('Today')}} </th>
                                        <td id="video_count_curr"> {{$today_videos}} </td>
                                    </tr>
                                    <tr>
                                        <th id="video_text_past"> {{__('Yesterday')}} </th>
                                        <td id="video_count_past"> {{$yesterday_videos}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body border-top text-center mt-3">
                            <div class="btn-group btn-group-md py-2 video_statistics" role="group">
                                <button type="button" id="btn-h" class="btn btn-outline-primary" onclick="video_dashboard('h')"> 1H </button>
                                <button type="button" id="btn-d" class="btn btn-outline-primary border-radius-0 bg-primary text-white" onclick="video_dashboard('d')"> 1D </button>
                                <button type="button" id="btn-w" class="btn btn-outline-primary border-radius-0" onclick="video_dashboard('w')"> 1W </button>
                                <button type="button" id="btn-m" class="btn btn-outline-primary" onclick="video_dashboard('m')"> 1M </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Social Visitor --}}
            <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary"> {{__('Social Visitor')}} </h5>
                        <div class="row">
                            <div class="col-6">
                                <div class="card card-statistic-2">
                                    <div class="card-icon bg-facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4> {{__('Facebook Users')}} </h4>
                                        </div>
                                        <div class="card-body">
                                            {{$fb_user}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-statistic-2">
                                    <div class="card-icon bg-google">
                                        <i class="fab fa-google"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4> {{__('Google Users')}} </h4>
                                        </div>
                                        <div class="card-body">
                                            {{$google_user}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                            <div class="col-6">
                                <div class="card card-statistic-2">
                                    <div class="card-icon bg-warning">
                                        <i class="fas fa-at"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4> {{$app_name}} {{__('Users')}} </h4>
                                        </div>
                                        <div class="card-body">
                                            {{$local_user}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card card-statistic-2">
                                    <div class="card-icon bg-black">
                                        <i class="fab fa-apple"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4> {{__('Apple Users')}} </h4>
                                        </div>
                                        <div class="card-body">
                                            {{$apple_user}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-12 col-sm-12 col-lg-7">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"> {{__('Popular User')}} </h5>
                        <ul class="list-unstyled user-details list-unstyled-border list-unstyled-noborder p-0">
                            
                            @if (count($popular_user) == 0)
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <h2> {{__('There are no users.')}} </h2>
                                </div>
                            @else
                                @foreach ($popular_user as $item)
                                    <li class="media">
                                        <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$item['image']) }}">
                                        <a href="{{ url('admin/user/'.$item['id']) }}" class="media-body">
                                            <div class="media-body">
                                                <div class="media-title"> {{$item['name']}} </div>
                                                <div class="text-muted"> {{$item['user_id']}} </div>
                                            </div>
                                        </a>
                                        <div class="media-items">
                                            <div class="media-item">
                                                <div class="media-value"> {{$item['video_count']}} </div>
                                                <div class="media-label"> {{__('Posts')}} </div>
                                            </div>
                                            <div class="media-item">
                                                <div class="media-value"> {{$item['followersCount']}} </div>
                                                <div class="media-label"> {{__('Followers')}} </div>
                                            </div>
                                            <div class="media-item">
                                                <div class="media-value"> {{$item['followingCount']}} </div>
                                                <div class="media-label"> {{__('Following')}} </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-4"> {{__('Login vs Guest')}} </h5>
                        <canvas id="myChart_guest" height="195"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
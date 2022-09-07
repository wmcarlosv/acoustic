@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Reports')
    ])
    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Reports')}} </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            
                            <!--  Top View Videos -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Viewed Videos')}} </h4>
                                        <p> {{__('Top 50 Most Viewed Videos')}} </p>
                                        <a href=" {{url('admin/report/most-viewed-video')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!--  Top Likes Videos -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-heart"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Liked Videos')}} </h4>
                                        <p> {{__('Top 50 Most Liked Videos')}} </p>
                                        <a href=" {{url('admin/report/most-liked-video')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!--  Top Used Songs -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-music"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Used Songs')}} </h4>
                                        <p> {{__('Top 50 Most Used Songs')}} </p>
                                        <a href=" {{url('admin/report/most-used-song')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                               
                            <!--  Top Used Audio -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-microphone-alt"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Used Audios')}} </h4>
                                        <p> {{__('Top 50 Most Used Audio')}} </p>
                                        <a href=" {{url('admin/report/most-used-audio')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>    

                            <!--  Top Used Hashtags -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-hashtag"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Used Hashtags')}} </h4>
                                        <p> {{__('Top 50 Most Used Hashtags')}} </p>
                                        <a href=" {{url('admin/report/most-used-tag')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <!--  Top Used Challenges -->
                            <div class="col-lg-6">
                                <div class="card card-large-icons">
                                    <div class="card-icon bg-primary text-white">
                                        <i class="fas fa-trophy"></i>
                                    </div>
                                    <div class="card-body">
                                        <h4> {{__('Most Used Challenges')}} </h4>
                                        <p> {{__('Top 50 Most Used Challenges')}} </p>
                                        <a href=" {{url('admin/report/most-used-challenge')}}" class="card-cta">
                                            {{__('View Report')}} <i class="fas fa-chevron-right"></i>
                                        </a>
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
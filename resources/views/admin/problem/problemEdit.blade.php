@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Give Answer'),
            'headerData' => __('User Problems'),
            'url' => 'admin/problem_report'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Give Answer')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/problem_report/'.$problem->id)}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body px-5">
                            <div class="row">
                                <div class="tickets w-100">
                                    <div class="ticket-content">
                                        <div class="ticket-header">
                                            <div class="ticket-sender-picture img-shadow">
                                                <img src="{{url('image/user/'.$problem->userImage)}}" alt="image">
                                            </div>
                                            <div class="ticket-detail">
                                                <div class="ticket-title">
                                                    <h4> {{$problem->subject}} </h4>
                                                </div>
                                            <div class="ticket-info">
                                                <div class="font-weight-600"> {{$problem->userName}} </div>
                                                <div class="bullet"></div>
                                                <div class="text-primary font-weight-600"> {{$problem->createTime}} </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="ticket-description">
                                            <p> {{$problem->issue}} </p>
                                            @if ($problem->ss != null)
                                                <div class="gallery lightBox-banner">
                                                    @foreach (json_decode($problem->ss) as $item)
                                                        <a href="{{ url('/image/user_problems/'.$item) }}">
                                                            <img src="{{ url('/image/user_problems/'.$item) }}" class="gallery-item">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="ticket-divider"></div>
                                            <div class="ticket-form">
                                                <div class="form-group">
                                                    <textarea class="summernote form-control" name="ans" required>{{old('ans',$problem->ans)}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit"> {{__('Submit')}} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('User Reports')
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
                        <h4> {{__('All User Reports')}} </h4>
                    </div>
                    <div class="card-body">
                       
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('User')}} </th>
                                        <th> {{__('Login')}} </th>
                                        <th> {{__('Account')}} </th>
                                        <th> {{__('Reports')}} </th>
                                        <th> {{__('Reasons')}} </th>
                                        <th> {{__('Created At')}} </th>
                                        <th> {{__('Action')}} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($reports as $report)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td>
                                                <div class="media">
                                                    <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$report->reportUser->image) }}">
                                                    <div class="media-body">
                                                        <div class="media-title mb-0">
                                                            {{ $report->reportUser->name }}
                                                        </div>
                                                        <div class="media-description text-muted"> {{$report->reportUser->user_id }} </div>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <i class="fab fa-google provider {{ $report->reportUser->provider == "google"? 'text-google':'text-muted' }}"></i>
                                                <i class="fab fab fa-facebook-f provider {{ $report->reportUser->provider == "facebook"? 'text-facebook':'text-muted' }}"></i>
                                                <i class="fab fa-apple provider {{ $report->reportUser->provider == "apple"? 'text-black':'text-muted' }}"></i>
                                                <i class="fas fa-at provider {{ $report->reportUser->provider == "local"? 'text-warning':'text-muted' }}"></i>
                                            </td>
                                            
                                            <td>
                                                @if ($report->reportUser->follower_request == 1)
                                                    <h6> <span class="badge badge-danger"> Private </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-success"> Public </span> </h6>
                                                @endif
                                            </td>
                                            <td> {{$report->total}} </td>
                                            <td>
                                                @foreach ($report->reportUser->reportReasons as $key => $item)
                                                    {{$key}} - {{$item}} <br>
                                                @endforeach
                                            </td>
                                            <td> {{$report->reportUser->created_at}} </td>
                                            <td>
                                                @can('app_user_access')
                                                    <a href="{{ url('admin/user/'.$report->reportUser->id) }}" class="btn btn-warning">
                                                        <i class="far fa-eye action_icon"></i>
                                                    </a>
                                                @endcan
                                                @can('app_user_report_delete')
                                                    <button class="btn-danger btn" onclick="all_delete('admin/user',{{$report->reportUser->id}})">
                                                        <i class="fas fa-trash action_icon"></i>
                                                    </button>
                                                @endcan
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
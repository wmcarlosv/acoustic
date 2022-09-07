@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Video Reports')
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
                        <h4> {{__('All Video Reports')}} </h4>
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
                                        <th> {{__('Approved')}} </th>
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
                                                <a href="{{ url('/admin/user/'.$report->reportVideo->user->id) }}">
                                                    <div class="media">
                                                        <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$report->reportVideo->user->image) }}">
                                                        <div class="media-body">
                                                            <div class="media-title mb-0">
                                                                {{ $report->reportVideo->user->name }}
                                                            </div>
                                                            <div class="media-description text-muted"> {{$report->reportVideo->user->user_id }} </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/video/'.$report->reportVideo->id) }}">
                                                    <img src="{{ url('/image/video/'.$report->reportVideo->screenshot) }}" class="border-radius-10" height="50" width="50" >
                                                </a>
                                            </td>
                                            <td>
                                                <h6> <span class="badge badge-success"> {{$report->reportVideo->view}} </span> </h6>
                                            </td>
                                            
                                            <td> {{$report->reportVideo->viewCount}} </td>
                                            <td>
                                                @cannot('video_edit')
                                                    @if ($report->reportVideo->is_approved == 1)
                                                        <h6> <span class="badge badge-success"> Approved </span> </h6>
                                                    @else
                                                        <h6> <span class="badge badge-danger"> Not Approved </span> </h6>
                                                    @endif
                                                @endcannot
                                                @can('video_edit')
                                                    <label class="">
                                                        <input type="checkbox" name="custom-switch-checkbox" onchange="approve_video({{$report->reportVideo->id}})" class="custom-switch-input" {{$report->reportVideo->is_approved == 1? 'checked': ''}}>
                                                        <span class="custom-switch-indicator"></span>
                                                    </label>
                                                @endcan
                                            </td>
                                            <td> {{$report->total}} </td>

                                            <td>
                                                @foreach ($report->reportVideo->reportReasons as $key => $item)
                                                    {{$key}} - {{$item}} <br>
                                                @endforeach
                                            </td>
                                            <td> {{$report->reportVideo->created_at}} </td>
                                            <td>
                                                @can('video_report_delete')
                                                    <button class="btn-danger btn" onclick="all_delete('admin/user',{{$report->reportVideo->id}})">
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
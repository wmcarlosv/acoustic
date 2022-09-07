@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Comment Reports')
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
                        <h4> {{__('All Comment Reports')}} </h4>
                    </div>
                    <div class="card-body">
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('User')}} </th>
                                        <th> {{__('Comment')}} </th>
                                        <th> {{__('Likes')}} </th>
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
                                                    <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$report->reportComment->user->image) }}">
                                                    <div class="media-body">
                                                        <div class="media-title mb-0">
                                                            {{ $report->reportComment->user->name }}
                                                        </div>
                                                        <div class="media-description text-muted"> {{$report->reportComment->user->user_id }} </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{$report->reportComment->comment}} </td>
                                            <td> {{$report->reportComment->likesCount}} </td>
                                            <td> {{$report->total}} </td>
                                            <td>
                                                @foreach ($report->reportComment->reportReasons as $key => $item)
                                                    {{$key}} - {{$item}} <br>
                                                @endforeach
                                            </td>
                                            <td> {{$report->reportComment->created_at}} </td>
                                            <td>
                                                @can('comment_delete')
                                                    <button class="btn-danger btn" onclick="all_delete('admin/comment',{{$report->reportComment->id}})">
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
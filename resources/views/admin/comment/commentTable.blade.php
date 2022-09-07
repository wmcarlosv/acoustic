@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Comments')
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
                        <h4> {{__('All Comments')}} </h4>
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
                                        <th> {{__('Created At')}} </th>
                                        @if (Gate::check('comment_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($comments as $comment)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td>
                                                <div class="media">
                                                    <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$comment->user->image) }}">
                                                    <div class="media-body">
                                                        <div class="media-title mb-0">
                                                            {{ $comment->user->name }}
                                                        </div>
                                                        <div class="media-description text-muted"> {{$comment->user->user_id }} </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td> {{$comment->comment}} </td>
                                            <td> {{$comment->likesCount}} </td>
                                            <td> {{$comment->created_at}} </td>
                                            
                                            @if (Gate::check('comment_delete'))
                                                <td>
                                                    @can('comment_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/comment',{{$comment->id}})">
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
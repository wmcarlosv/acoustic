@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('User Problems')
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> {{__('Help Your Users')}} </h4>
                    </div>
                    <div class="card-body">
                        
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('User')}} </th>
                                        <th> {{__('Subject')}} </th>
                                        <th> {{__('Issue')}} </th>
                                        <th> {{__('Answered')}} </th>
                                        @if (Gate::check('user_problem_edit') || Gate::check('user_problem_delete'))
                                            <th> {{__('Action')}} </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($problems as $problem)
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            
                                            <td>
                                                <a href="{{ $problem->user_id != null ? url('/admin/user/'.$problem->user_id) : '' }}" class="{{ $problem->user_id != null ? '' : 'pointer-none' }}">
                                                    <div class="media">
                                                        <img alt="image" class="mr-3 rounded-circle" width="50" src="{{ url('/image/user/'.$problem->userImage) }}">
                                                        <div class="media-body">
                                                            <div class="media-title mb-0">
                                                                {{ $problem->userName }}
                                                            </div>
                                                            <div class="media-description text-muted"> {{$problem->name }} </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>{{ substr($problem->subject,0,30)}} {{ strlen($problem->subject) > 30 ? '....' : ""}}</td>
                                            <td>{{ substr($problem->issue,0,60)}} {{ strlen($problem->issue) > 60 ? '....' : ""}}</td>
                                            <td>
                                                @if ($problem->ans != null)
                                                    <h6> <span class="badge badge-success"> Yes </span> </h6>
                                                @else
                                                    <h6> <span class="badge badge-danger"> No </span> </h6>
                                                @endif
                                            </td>
                                            
                                            @if (Gate::check('user_problem_edit') || Gate::check('user_problem_delete'))
                                                <td>
                                                    @can('user_problem_edit')
                                                        <a href="{{ url('admin/problem_report/'.$problem->id.'/edit') }}" class="btn btn-info">
                                                            <i class="far fa-edit action_icon"></i>
                                                        </a>
                                                    @endcan
                                                    @can('user_problem_delete')
                                                        <button class="btn-danger btn" onclick="all_delete('admin/problem_report',{{$problem->id}})">
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
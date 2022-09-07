@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Notification Templates')
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
                        <h4> {{__('All Notification Templates')}} </h4>
                        @can('notification_create')
                            <a href="{{ url('/admin/notification/create') }}" class="btn btn-icon icon-left btn-success"><i class="fas fa-plus"></i> {{__('Add New')}} </a>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="section-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="nav nav-pills flex-column nav-nots">
                                                @foreach ($templates as $key => $temp)
                                                    @if ($key == 0)
                                                        @php
                                                            $first = array();
                                                            $first = $temp;
                                                        @endphp
                                                    @endif
                                                    <li class="nav-item mb-3 cursor-pointer" onclick="template_edit({{$temp->id}})"> <span class="nav-link {{ $loop->iteration == 1 ? 'active':'' }}" id="nav-title{{$temp->id}}"> {{$temp->title}} </span> </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <form class="" id="template_form" action="{{url('/admin/notification/'.$first->id)}}" method="post">
                                    @csrf
                                    @method('put')
                                        <div class="card" id="settings-card">
                                            <div class="card-header">
                                                <h4 id="temp_title"> {{$first->title}} </h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label> {{__('Subject')}} </label>
                                                    <input type="text" name="subject" value="{{ $first->subject }}" class="form-control @error('subject') is-invalid @enderror" placeholder="{{__('Template Subject')}}">
                                                    @error('subject')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label> {{__('Mail Content')}} </label>
                                                    <textarea name="mail_content" class="form-control textarea_editor  @error('mail_content') is-invalid @enderror" placeholder="{{__('Mail Content')}}">{{ $first->mail_content }}</textarea>
                                                    @error('mail_content')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label> {{__('Message Content')}} </label>
                                                    <input type="text" name="message_content" value="{{ $first->msg_content }}" class="form-control @error('message_content') is-invalid @enderror" placeholder="{{__('Message Content')}}">
                                                    @error('message_content')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="card-footer bg-whitesmoke text-md-right">
                                                <button type="submit" class="btn btn-primary"> {{__('Save Changes')}} </button>
                                            </div>
                                        </div>
                                    </form>
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
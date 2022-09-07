@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Template'),
            'headerData' => __('Notification Templates'),
            'url' => 'admin/notification'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Template')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/notification')}}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Title')}} </label>
                                        <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Template Title')}}" required>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Subject')}} </label>
                                        <input type="text" name="subject" value="{{old('subject')}}" class="form-control @error('subject') is-invalid @enderror" placeholder="{{__('Template Subject')}}" required>
                                        @error('subject')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label> {{__('Mail Content')}} </label>
                                        <textarea name="mail_content" class="form-control textarea_editor  @error('mail_content') is-invalid @enderror" placeholder="{{__('Mail Content')}}" required>{{old('mail_content')}}</textarea>
                                        @error('mail_content')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Message Content')}} </label>
                                        <input type="text" name="message_content" value="{{ old('message_content') }}" class="form-control @error('message_content') is-invalid @enderror" placeholder="{{__('Message Content')}}" required>
                                        @error('message_content')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
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
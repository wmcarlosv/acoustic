@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Edit Song'),
            'headerData' => __('Songs'),
            'url' => 'admin/songs'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Edit Song')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/songs/'.$song->id)}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-5 webkit-center">
                                    <label for="image">{{__('Cover Image')}}</label>
                                    <div class="avatar-upload avatar-box avatar-box-left">
                                        <div class="avatar-edit">
                                            <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg"/>
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"  style="background-image: url({{url('image/song/'.$song->image)}});">
                                            </div>
                                        </div>
                                    </div>
                                    @error('image')
                                        <div class="invalid-feedback display-block mt-3">
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Title')}} </label>
                                        <input type="text" name="title" value="{{ old('title',$song->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Song Title')}}" required>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Artist')}} </label>
                                        <input type="text" name="artist" value="{{ old('artist',$song->artist) }}" class="form-control @error('artist') is-invalid @enderror" placeholder="{{__('Artist Name')}}" required>
                                        @error('artist')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Album / Movie')}} </label>
                                        <input type="text" name="movie" value="{{ old('movie',$song->movie) }}" class="form-control @error('movie') is-invalid @enderror" placeholder="{{__('Album / Movie Name')}}">
                                        @error('movie')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
    
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-5">
                                    <div class="form-group">
                                        <label> {{__('Audio')}} </label>
                                        <div class="custom-file">
                                            <input type="file" id="audio" accept="audio/*" name="audio" class="custom-file-input form-control @error('title') is-invalid @enderror" placeholder="{{__('Song Audio')}}">
                                            <label class="custom-file-label" id="file-name"> {{ $song->audio }} </label>
                                        </div>
                                        @error('audio')
                                            <div class="invalid-feedback display-block ">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Duration')}} </label>
                                        <div class="input-group">
                                            <input type="number" name="duration" value="{{ old('duration',$song->duration) }}" class="form-control @error('duration') is-invalid @enderror" placeholder="{{__('Song Duration')}}" required>
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    {{__('Seconds')}}
                                                </div>
                                            </div>
                                        </div>
                                        @error('duration')
                                            <div class="invalid-feedback display-block ">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Status')}} </label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="1" {{(old('status', $song->status) == "1")? 'selected':''}}> {{__('Active')}} </option>
                                            <option value="0" {{(old('status', $song->status) == "0")? 'selected':''}}> {{__('Inactive')}} </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label> {{__('Song Sections')}} </label>
                                        <select name="sections[]" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}" class="form-control select2 select2_multi_section @error('sections') is-invalid @enderror"  multiple="multiple" required>
                                            @foreach ($sections as $section)
                                                <option value="{{$section->id}}" {{ (collect(old('sections'))->contains($section->id)) ? 'selected':'' }} <?php if (in_array($section->id,json_decode($song->section_id))) { echo "selected"; } ?>> {{$section->title}} </option>
                                            @endforeach
                                        </select>
                                        @error('sections')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Song Language')}} </label>
                                        <select name="language" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}" class="form-control select2 select2_language @error('language') is-invalid @enderror" required>
                                            @foreach ($languages as $language)
                                                <option value="{{$language->name}}" {{ $song->lang == $language->name ? 'selected' : '' }}> {{$language->name}} </option>
                                            @endforeach
                                        </select>
                                        @error('language')
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
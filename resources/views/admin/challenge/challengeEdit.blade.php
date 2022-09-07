@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Edit Challenge'),
            'headerData' => __('Challenges'),
            'url' => 'admin/challenge'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Edit Challenge')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/challenge/'.$challenge->id)}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-4 webkit-center">
                                    <label for="image">{{__('Image')}}</label>
                                    <div class="avatar-upload avatar-box avatar-box-left">
                                        <div class="avatar-edit">
                                            <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg"/>
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="background-image: url({{url('image/challenge/'.$challenge->image)}});">
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
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-hashtag"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="title" value="{{ old('title',$challenge->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="{{__('Challenge Title')}}" required>
                                        </div>
                                        @error('title')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
    
                                    <div class="form-group">
                                        <label> {{__('Description')}} </label>
                                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" placeholder="{{__('Challenge Description')}}" required>{{ old('description',$challenge->desc) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Status')}} </label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="1" {{(old('status', $challenge->status) == "1")? 'selected':''}}> {{__('Active')}} </option>
                                            <option value="0" {{(old('status', $challenge->status) == "0")? 'selected':''}}> {{__('Inactive')}} </option>
                                        </select>
                                        @error('status')
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
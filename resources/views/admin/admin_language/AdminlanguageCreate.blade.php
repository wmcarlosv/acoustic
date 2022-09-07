@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Admin Language'),
            'headerData' => __('Admin Language'),
            'url' => 'admin/settings/language'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Admin Language')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/settings/language')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-12 col-md-6 col-lg-4 webkit-center">
                                    <label for="image">{{__('Flag')}}</label>
                                    <div class="avatar-upload avatar-box avatar-box-left">
                                        <div class="avatar-edit">
                                            <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg"/>
                                            <label for="image"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview">
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
                                        <label> {{__('Name')}} </label>
                                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Language Name')}}"  required>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label> {{__('Language JSON File')}} </label>
                                        <input type="file" name="file" accept="Application/JSON" class="form-control @error('file') is-invalid @enderror" required>
                                        @error('file')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label> {{__('Direction')}} </label>
                                        <select name="direction" class="form-control @error('direction') is-invalid @enderror" required>
                                            <option value="ltr" {{(old('direction') == "ltr")? 'selected':''}}> {{__('LTR')}} </option>
                                            <option value="rtl" {{(old('direction') == "rtl")? 'selected':''}}> {{__('RTL')}} </option>
                                        </select>
                                        @error('direction')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Status')}} </label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                            <option value="1" {{(old('status') == "1")? 'selected':''}}> {{__('Active')}} </option>
                                            <option value="0" {{(old('status') == "0")? 'selected':''}}> {{__('Inactive')}} </option>
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
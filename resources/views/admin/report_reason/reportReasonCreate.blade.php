@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Report Reason'),
            'headerData' => __('Report Reasons'),
            'url' => 'admin/report'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Report Reason')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/report-reason')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Reason')}} </label>
                                        <textarea name="reason" class="form-control report_reason @error('reason') is-invalid @enderror" placeholder="{{__('Report Reason')}}" required>{{ old('reason') }}</textarea>
                                        @error('reason')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">

                                    <div class="form-group">
                                        <label> {{__('Status')}} </label>
                                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="1" {{(old('status') == "1")? 'selected':''}}> {{__('Active')}} </option>
                                            <option value="0" {{(old('status') == "0")? 'selected':''}}> {{__('Inactive')}} </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label> {{__('Reason For')}} </label>
                                        <select name="reason_for[]" class="form-control select2 select2_multi_reason_type @error('reason_for') is-invalid @enderror" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}" multiple="multiple"  required>
                                            <option value="User" {{ (collect(old('reason_for'))->contains('User')) ? 'selected':'' }}> {{__('User')}} </option>
                                            <option value="Comment" {{ (collect(old('reason_for'))->contains('Comment')) ? 'selected':'' }} > {{__('Comment')}} </option>
                                            <option value="Video" {{ (collect(old('reason_for'))->contains('Video')) ? 'selected':'' }} > {{__('Video')}} </option>
                                        </select>
                                        @error('reason_for')
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
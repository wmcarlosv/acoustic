@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Policy & Terms')
    ])
    
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form method="POST" action="{{url('/admin/privacy_save')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header d-felx justify-content-between">
                            <h4> {{__('Privacy Policy')}} </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="privacy_policy" class="form-control textarea_editor  @error('privacy_policy') is-invalid @enderror">{{old('privacy_policy',$setting->privacy_policy)}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-header d-felx justify-content-between">
                            <h4> {{__('Terms of Use')}} </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea name="terms_of_use" class="form-control textarea_editor  @error('terms_of_use') is-invalid @enderror">{{old('terms_of_use',$setting->terms_of_use)}}</textarea>
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
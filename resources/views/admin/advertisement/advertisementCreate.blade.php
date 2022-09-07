@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Advertisement'),
            'headerData' => __('Advertisements'),
            'url' => 'admin/advertisements'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Advertisement')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/advertisements')}}" class="needs-validation" novalidate="" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Location')}} </label>
                                        <select name="location" class="form-control @error('location') is-invalid @enderror">
                                            <option value="Banner" {{(old('location') == "Banner")? 'selected':''}}> Banner </option>
                                            <option value="Trending" {{(old('location') == "Trending")? 'selected':''}}> Trending </option>
                                            <option value="Player" {{(old('location') == "Player")? 'selected':''}}> Player </option>
                                            <option value="Search" {{(old('location') == "Search")? 'selected':''}}> Search </option>
                                            <option value="Startup" {{(old('location') == "Startup")? 'selected':''}}> Startup </option>
                                        </select>
                                        @error('location')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Network')}} </label>
                                        <select name="network" id="network-dd" class="form-control @error('network') is-invalid @enderror">
                                            <option value="admob" {{(old('network') == "admob")? 'selected':''}}> AdMob </option>
                                            <option value="facebook" {{(old('network') == "facebook")? 'selected':''}}> Facebook </option>
                                        </select>
                                        @error('network')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Type')}} </label>
                                        <select name="type" id="type-dd" class="form-control @error('type') is-invalid @enderror">
                                            <option value="Banner" {{(old('type') == "Banner")? 'selected':''}}> Banner </option>
                                            <option value="Interstitial" {{(old('type') == "Interstitial")? 'selected':''}}> Interstitial </option>
                                            <option value="Native" {{(old('type') == "Native")? 'selected':''}}> Native </option>
                                        </select>
                                        @error('type')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Placement / Unit')}} </label>
                                        <input type="text" name="unit" value="{{ old('unit') }}" class="form-control @error('unit') is-invalid @enderror" placeholder="{{__('Placement or Unit')}}" required>
                                        @error('unit')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label> {{__('Interval')}} </label>
                                        <input type="number" name="interval" value="{{ old('interval') }}" class="form-control @error('interval') is-invalid @enderror" placeholder="{{__('Interval')}}">
                                        @error('interval')
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
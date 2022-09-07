@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('New Role'),
            'headerData' => __('Roles'),
            'url' => 'admin/role'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Create New Role')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/role')}}" class="needs-validation" novalidate="">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label> {{__('Name')}} </label>
                                <input type="text" name="name"  value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Role Name')}}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label> {{__('Permissions')}} </label>
                                <select name="permissions[]" class="form-control select2 select2_multi_permissions @error('permissions') is-invalid @enderror" dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}"  multiple="multiple" required>
                                    @foreach ($permissions as $per)
                                        <option value="{{$per->id}}" {{ (collect(old('permissions'))->contains($per->id)) ? 'selected':'' }}> {{$per->name}} </option>
                                    @endforeach
                                </select>
                                @error('permissions')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
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
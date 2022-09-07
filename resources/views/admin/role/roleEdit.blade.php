@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Edit Role'),
            'headerData' => __('Roles'),
            'url' => 'admin/role'
    ])
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Edit Role')}} </h4>
                    </div>
                    <form method="POST" action="{{url('/admin/role/'.$role->id)}}" class="needs-validation" novalidate="">
                        @csrf
                        @method('put')
                        <div class="card-body">
                            <div class="form-group">
                                <label> {{__('Name')}} </label>
                                <input type="text" name="name" value="{{ old('name',$role->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="{{__('Role Name')}}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            
                            <div class="form-group ">
                                <label> {{__('Permissions')}} </label>
                                <select name="permissions[]" class="form-control select2_multi_permissions @error('permissions') is-invalid @enderror"  multiple="multiple">
                                    @foreach ($permissions as $per)
                                        <option value="{{$per->id}}" {{ (collect(old('permissions'))->contains($per->id)) ? 'selected':'' }}
                                            {{ $role->permissions->contains($per->id) == 1 ? 'selected' : '' }}>
                                            {{$per->name}} 
                                        </option>
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
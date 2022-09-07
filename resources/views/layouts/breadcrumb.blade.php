
<div class="section-header">
    <h1> {{$title}} </h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="{{url('/admin/dashboard')}}"> {{__('Dashboard')}} </a></div>
        @if (isset($headerData) && isset($url))
            <div class="breadcrumb-item"><a href="{{url('/'.$url)}}"> {{$headerData}} </a></div>
        @endif
        <div class="breadcrumb-item"> {{$title}} </div>
    </div>
</div>
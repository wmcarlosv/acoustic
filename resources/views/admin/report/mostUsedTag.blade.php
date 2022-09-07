@extends('layouts.app')
@section('content')
    
<section class="section">
    
    @include('layouts.breadcrumb', [
            'title' => __('Most Used Hashtags'),
            'headerData' => __('Report'),
            'url' => 'admin/report'
    ])
    @include('layouts.filter',[
        'url' => 'admin/report/most-used-tag'
    ])

    <div class="section-body">
        
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header d-felx justify-content-between">
                        <h4> {{__('Top 50 Most Used Hashtags')}} </h4>
                    </div>
                    <div class="card-body">
                       
                        @include('admin.export_btns')
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="datatable">
                                <thead>
                                    <tr>
                                        <th> {{__('#')}} </th>
                                        <th> {{__('Name')}} </th>
                                        <th> {{__('In Videos')}} </th>
                                        <th> {{__('In Comments')}} </th>
                                        <th> {{__('Total Used')}} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hashtags as $tag)
                                        @if ($loop->iteration == 51)
                                            @break;
                                        @endif
                                        <tr>
                                            <td> {{$loop->iteration}} </td>
                                            <td> {{ $tag['name'] }} </td>
                                            <td> {{ $tag['video'] }} </td>
                                            <td> {{ $tag['comment'] }} </td>
                                            <td> {{ $tag['total'] }} </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<div class="section-filter mt-0 border-top-primary">
    <form action="{{url('/'.$url)}}" method="post" class="w-100"  class="needs-validation" novalidate="">
        @csrf
        <div class="row">
            <div class="text-primary h4 mb-4 pl-3">
                <i class="fa fa-filter" aria-hidden="true"></i>  {{__('Filters')}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="form-group">
                    <select name="type" onchange="report_filter()"
                        dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}"
                        class="form-control select2_filter_type">
                        <option value="all" {{ $type == 'all'?'selected':'' }}> All </option>
                        <option value="day" {{ $type == 'day'?'selected':'' }}> Day </option>
                        <option value="week" {{ $type == 'week'?'selected':'' }}> Week </option>
                        <option value="month" {{ $type == 'month'?'selected':'' }}> Month </option>
                        <option value="year" {{ $type == 'year'?'selected':'' }}> Year </option>
                        <option value="period" {{ $type == 'period'?'selected':'' }}> Period </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 filter">
                <div class="form-group">
                    <input type="text" class="form-control filter_textbox filter_all cursor-not-allowed {{ $type == 'all'?'':'display-none' }}" value="All" name="filter_textbox_day" readonly>

                    <input type="text"  class="form-control filter_textbox filter_day {{ $type == 'day'?'':'display-none' }}" value="{{ isset($all_req['filter_textbox_day'])?$all_req['filter_textbox_day']:'' }}" name="filter_textbox_day" placeholder="{{__('Select Date')}}">
               
                    <input type="text" class="form-control filter_textbox filter_week {{ $type == 'week'?'':'display-none' }}" value="{{ isset($all_req['filter_textbox_week'])?$all_req['filter_textbox_week']:'' }}" name="filter_textbox_week" placeholder="{{__('Select Week')}}">
               
                    <select  dir="{{ session()->has('direction')&& session('direction') == 'rtl'? 'rtl':''}}"
                        class="form-control filter_textbox filter_month mb-2 {{ $type == 'month'?'':'display-none' }}" name="filter_textbox_month" placeholder="{{__('Select Month')}}">
                        @if (isset($all_req['filter_textbox_month']))
                            <option value="01" {{ $all_req['filter_textbox_month'] == '01'?'selected':'' }}> January </option>
                            <option value="02" {{ $all_req['filter_textbox_month'] == '02'?'selected':'' }}> February </option>
                            <option value="03" {{ $all_req['filter_textbox_month'] == '03'?'selected':'' }}> March </option>
                            <option value="04" {{ $all_req['filter_textbox_month'] == '04'?'selected':'' }}> April </option>
                            <option value="05" {{ $all_req['filter_textbox_month'] == '05'?'selected':'' }}> May </option>
                            <option value="06" {{ $all_req['filter_textbox_month'] == '06'?'selected':'' }}> June </option>
                            <option value="07" {{ $all_req['filter_textbox_month'] == '07'?'selected':'' }}> July </option>
                            <option value="08" {{ $all_req['filter_textbox_month'] == '08'?'selected':'' }}> August </option>
                            <option value="09" {{ $all_req['filter_textbox_month'] == '09'?'selected':'' }}> September </option>
                            <option value="10" {{ $all_req['filter_textbox_month'] == '10'?'selected':'' }}> October </option>
                            <option value="11" {{ $all_req['filter_textbox_month'] == '11'?'selected':'' }}> November </option>
                            <option value="12" {{ $all_req['filter_textbox_month'] == '12'?'selected':'' }}> December </option>
                        @else
                            <option value="01"> January </option>
                            <option value="02"> February </option>
                            <option value="03"> March </option>
                            <option value="04"> April </option>
                            <option value="05"> May </option>
                            <option value="06"> June </option>
                            <option value="07"> July </option>
                            <option value="08"> August </option>
                            <option value="09"> September </option>
                            <option value="10"> October </option>
                            <option value="11"> November </option>
                            <option value="12"> December </option>
                        @endif
                    </select>
                    
                    <input type="number" value="{{ isset($all_req['filter_textbox_year'])? $all_req['filter_textbox_year'] :date('Y')}}"
                        max="{{date('Y')}}" min="0000" class="form-control filter_textbox filter_year {{ $type == 'month' || $type == 'year'?'':'display-none' }}"
                        name="filter_textbox_year" placeholder="{{__('Select Year')}}">

                    <input type="text" class="form-control filter_period filter_textbox {{ $type == 'period'?'':'display-none' }}"
                        value="{{ isset($all_req['filter_textbox_period'])?$all_req['filter_textbox_period']:'' }}"
                        name="filter_textbox_period" placeholder="{{__('Select Range')}}">

                </div>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="form-group mt-auto rtl-float-right">
                    <button class="btn btn-primary" type="submit"> {{__('Submit')}} </button>
                </div>
            </div>
        </div>
    </form>
</div>
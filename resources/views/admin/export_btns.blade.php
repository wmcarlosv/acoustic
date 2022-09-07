<div class="dropdown d-inline show export-btns">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-download"></i> {{__('Export')}}
    </button>
    <div class="dropdown-menu"> 
        <a class="dropdown-item has-icon" id="export_print">
            <span class="navi-icon">
                <i class="fa fa-print"></i>
            </span>
            <span class="navi-text ml-2">{{__('Print')}}</span>
        </a>

        
        <a class="dropdown-item has-icon" id="export_copy">
            <span class="navi-icon">
                <i class="fa fa-copy"></i>
            </span>
            <span class="navi-text ml-2">{{__('Copy')}}</span>
        </a>
        
        <a class="dropdown-item has-icon" id="export_excel">
            <span class="navi-icon">
                <i class="fa fa-file-excel"></i>
            </span>
            <span class="navi-text ml-2">{{__('Excel')}}</span>
        </a>
        
        <a class="dropdown-item has-icon" id="export_csv">
            <span class="navi-icon">
                <i class="fa fa-file-csv"></i>
            </span>
            <span class="navi-text ml-2">{{__('CSV')}}</span>
        </a>
        
        <a class="dropdown-item has-icon" id="export_pdf">
            <span class="navi-icon">
                <i class="fa fa-file-pdf"></i>
            </span>
            <span class="navi-text ml-2">{{__('PDF')}}</span>
        </a>
    </div>
</div>
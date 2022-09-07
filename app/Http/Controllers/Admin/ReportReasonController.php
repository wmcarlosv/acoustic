<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\AllReport;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ReportReasonController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('report_reason_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reports = Report::orderBy('id','desc')->get();
        return view('admin.report_reason.reportReasonTable', compact('reports'));
    }

    public function create()
    {
        abort_if(Gate::denies('report_reason_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.report_reason.reportReasonCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'bail|required',
            'status' => 'bail|required',
            'reason_for' => 'bail|required',
        ]);
        $report = new Report();
        $report->reason = $request->reason;
        $report->status = $request->status;
        $report->type = json_encode($request->reason_for);
        $report->save();
        return redirect()->route('report-reason.index')->withStatus(__('Report Reason Created Successfully.'));
    }

    public function show(Report $report)
    {
        //
    }

    public function edit($id)
    {
        abort_if(Gate::denies('report_reason_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $report = Report::find($id);
        return view('admin.report_reason.reportReasonEdit', compact('report'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'bail|required',
            'status' => 'bail|required',
            'reason_for' => 'bail|required',
        ]);

        $report = Report::find($id);
        $report->reason = $request->reason;
        $report->status = $request->status;
        $report->type = json_encode($request->reason_for);
        $report->save();
        return redirect()->route('report-reason.index')->withStatus(__('Report Reason Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('report_reason_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reason = Report::find($id);
        $other = Report::where('reason','Other')->first();
        $all_reports = AllReport::where('reason_id',$id)->get();
        foreach ($all_reports as $report) {
            $report->reason_id = $other->id;
            $report->save();
        }
        $reason->delete();
        return response()->json(['success' => true, 'msg' => __('Report Reason Deleted Successfully.')], 200);
    }
}

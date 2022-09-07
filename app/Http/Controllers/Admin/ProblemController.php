<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Problem;
use Illuminate\Http\Request;
use Gate;
use Redirect;
use Symfony\Component\HttpFoundation\Response;

class ProblemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_problem_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $problems = Problem::orderBy('id','desc')->get();
        return view('admin.problem.problemTable', compact('problems'));
    }

    public function edit($id)
    {
        abort_if(Gate::denies('user_problem_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $problem = Problem::find($id);
        return view('admin.problem.problemEdit', compact('problem'));
    }

    public function update(Request $request, $id)
    {
        $problem = Problem::find($id);
        $problem->ans = $request->ans;
        $problem->save();
        return redirect()->route('problem_report.index')->withStatus(__('Answer Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('user_problem_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $problem = Problem::find($id);
        if($problem->ss != null){
            foreach(json_decode($problem->ss) as $item){
                if(\File::exists(public_path('/image/user_problems/'. $item))){
                    \File::delete(public_path('/image/user_problems/'. $item));
                }
            }
        }
        $problem->delete();
        return response()->json(['success' => true, 'msg' => __('User Problem Deleted Successfully.')], 200);
    }
}

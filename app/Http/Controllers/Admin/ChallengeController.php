<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class ChallengeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('challenge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $challenges = Challenge::orderBy('id','desc')->get();
        return view('admin.challenge.challengeTable', compact('challenges'));
    }

    public function create()
    {
        abort_if(Gate::denies('challenge_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.challenge.challengeCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'title' => 'bail|required',
            'description' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $challenge = new Challenge();
        if(substr($request->title, 0, 1) == "#"){
            $challenge->title = $request->title;

        } else {
            $challenge->title = "#".$request->title;
        }
        $challenge->desc = $request->description;
        $challenge->status = $request->status;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'Challenge_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/challenge');
            $image->move($destinationPath, $name);
            $challenge->image = $name;
        }
        $challenge->save();
        return redirect()->route('challenge.index')->withStatus(__('Challenge Created Successfully.'));
    }

    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        abort_if(Gate::denies('challenge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge = Challenge::find($id);
        return view('admin.challenge.challengeEdit', compact('challenge'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required',
            'description' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $challenge = Challenge::find($id);
        if(substr($request->title, 0, 1) == "#"){
            $challenge->title = $request->title;

        } else {
            $challenge->title = "#".$request->title;
        }
        $challenge->desc = $request->description;
        $challenge->status = $request->status;
        
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/image/challenge/'. $challenge->image))){
                \File::delete(public_path('/image/challenge/'. $challenge->image));
            }
            $image = $request->file('image');
            $name = 'Challenge_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/challenge');
            $image->move($destinationPath, $name);
            $challenge->image = $name;
        }
        $challenge->save();
        return redirect()->route('challenge.index')->withStatus(__('Challenge Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('challenge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $challenge = Challenge::find($id);
        if(\File::exists(public_path('/image/challenge/'. $challenge->image))) {
            \File::delete(public_path('/image/challenge/'. $challenge->image));
        }
        $challenge->delete();
        return response()->json(['success' => true, 'msg' => __('Challenge Deleted Successfully.')], 200);
    }
}

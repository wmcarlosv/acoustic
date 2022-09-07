<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use Symfony\Component\HttpFoundation\Response;
use Gate;

class AdvertisementController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('advertisement_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $advertisements = Advertisement::orderBy('id','desc')->get();
        return view('admin.advertisement.advertisementTable', compact('advertisements'));
    }

    public function create()
    {
        abort_if(Gate::denies('advertisement_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.advertisement.advertisementCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'bail|required',
            'network' => 'bail|required',
            'unit' => 'bail|required',
            'type' => 'bail|required',
            'interval' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $ad = new Advertisement();
        $ad->location = $request->location;
        $ad->network = $request->network;
        $ad->unit = $request->unit;
        $ad->type = $request->type;
        $ad->interval = $request->interval;
        $ad->status = $request->status;
        $ad->save();
        return redirect()->route('advertisements.index')->withStatus(__('Advertisement Created Successfully.'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_if(Gate::denies('advertisement_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $advertisement = Advertisement::find($id);
        return view('admin.advertisement.advertisementEdit', compact('advertisement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'location' => 'bail|required',
            'network' => 'bail|required',
            'unit' => 'bail|required',
            'type' => 'bail|required',
            'interval' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $ad = Advertisement::find($id);
        $ad->location = $request->location;
        $ad->network = $request->network;
        $ad->unit = $request->unit;
        $ad->type = $request->type;
        $ad->interval = $request->interval;
        $ad->status = $request->status;
        $ad->save();
        return redirect()->route('advertisements.index')->withStatus(__('Advertisement Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('advertisement_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $ad = Advertisement::find($id);
        $ad->delete();
        return response()->json(['success' => true, 'msg' => __('Advertisement Deleted Successfully.')], 200);
    }
}

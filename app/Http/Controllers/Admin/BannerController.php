<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class BannerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banners = Banner::orderBy('id','desc')->get();
        return view('admin.banner.bannerTable', compact('banners'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.banner.bannerCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'title' => 'bail|required',
            'url' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $banner = new Banner();
        $banner->title = $request->title;
        $banner->url = $request->url;
        $banner->status = $request->status;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'Banner_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/banner');
            $image->move($destinationPath, $name);
            $banner->image = $name;
        }
        $banner->save();
        return redirect()->route('banner.index')->withStatus(__('Banner Created Successfully.'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banner = Banner::find($id);
        return view('admin.banner.bannerEdit', compact('banner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required',
            'url' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $banner = Banner::find($id);
        $banner->title = $request->title;
        $banner->url = $request->url;
        $banner->status = $request->status;
        
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/image/banner/'. $banner->image))){
                \File::delete(public_path('/image/banner/'. $banner->image));
            }
            $image = $request->file('image');
            $name = 'Banner_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/banner');
            $image->move($destinationPath, $name);
            $banner->image = $name;
        }
        $banner->save();
        return redirect()->route('banner.index')->withStatus(__('Banner Updated Successfully.'));

    }

    public function destroy($id)
    {
        abort_if(Gate::denies('banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $banner = Banner::find($id);
        if(\File::exists(public_path('/image/banner/'. $banner->image))){
            \File::delete(public_path('/image/banner/'. $banner->image));
        }
        $banner->delete();
        return response()->json(['success' => true, 'msg' => __('Banner Deleted Successfully.')], 200);
    }
}

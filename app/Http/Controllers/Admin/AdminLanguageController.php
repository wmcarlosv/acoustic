<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminLanguage;
use Gate;
use App;
use Redirect;
use Symfony\Component\HttpFoundation\Response;

class AdminLanguageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('admin_language_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $languages = AdminLanguage::orderBy('id','asc')->get();
        return view('admin.admin_language.AdminlanguageTable', compact('languages'));
    }

    public function create()
    {
        abort_if(Gate::denies('admin_language_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.admin_language.AdminlanguageCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required|unique:admin_language',
            'file' => 'bail|required',
            'image' => 'bail|required',
            'direction' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $language = new AdminLanguage();
        if($request->hasFile('file'))
        {
            $json = $request->file('file');
            $name = $request->name.'.'. $json->getClientOriginalExtension();
            $destinationPath = resource_path('/lang');
            $json->move($destinationPath, $name);
            $language->file = $name;
        }
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = $request->name.'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $language->image = $name;
        }
        $language->name = $request->name;
        $language->direction = $request->direction;
        $language->save();
        
        return Redirect::to('admin/settings/language')->with('status', __('Admin Language Created Successfully.'));
    }

    public function show($lang)
    {
        $icon = AdminLanguage::where('name',$lang)->first();
        App::setLocale($lang);
        session()->put('locale', $lang);
        if($icon){
            session()->put('direction', $icon->direction);
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        abort_if(Gate::denies('admin_language_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $language = AdminLanguage::find($id);
        return view('admin.admin_language.AdminlanguageEdit', compact('language'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'direction' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $language = AdminLanguage::find($id);
        if($request->hasFile('file'))
        {
            if(\File::exists(resource_path('lang/'. $language->file))){
                \File::delete(resource_path('lang/'. $language->file));
            }
            $json = $request->file('file');
            $name = $request->name.'.'. $json->getClientOriginalExtension();
            $destinationPath = resource_path('/lang');
            $json->move($destinationPath, $name);
            $language->file = $name;
        }
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/image/app/'. $language->image))){
                \File::delete(public_path('/image/app/'. $language->image));
            }
            $image = $request->file('image');
            $name = $request->name.'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/app');
            $image->move($destinationPath, $name);
            $language->image = $name;
        }
        $language->direction = $request->direction;
        $language->save();
        
        return Redirect::to('admin/settings/language')->with('status', __('Admin Language Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('admin_language_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $language = AdminLanguage::find($id);
        if(\File::exists(public_path('/image/app/'. $language->image))){
            \File::delete(public_path('/image/app/'. $language->image));
        }
        if(\File::exists(resource_path('lang/'. $language->file))){
            \File::delete(resource_path('lang/'. $language->file));
        }
        $language->delete();
        
        return response()->json(['success' => true, 'msg' => __('Admin Language Deleted Successfully.')], 200);
    }
}

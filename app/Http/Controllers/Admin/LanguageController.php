<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;


class LanguageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('language_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $languages = Language::orderBy('order','asc')->get();
        return view('admin.language.languageTable', compact('languages'));
    }
    
    public function create()
    {
        abort_if(Gate::denies('language_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.language.languageCreate');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $language = new Language();
        $language->name = $request->name;
        
        $all = Language::get();
        if(count($all) == 0) {
            $language->order = 1;
        } else {
            $last_order = Language::orderBy('order','desc')->first();
            $language->order = $last_order->order + 1;
        }

        $language->status = $request->status;
        $language->save();
        return redirect()->route('language.index')->withStatus(__('Language Created Successfully.'));
    }
    
    public function edit($id)
    {
        abort_if(Gate::denies('language_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $language = Language::find($id);
        return view('admin.language.languageEdit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $language = Language::find($id);
        $language->name = $request->name;
        $language->status = $request->status;
        $language->save();
        return redirect()->route('language.index')->withStatus(__('Language Updated Successfully.'));
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('language_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $language = Language::find($id)->delete();
        return response()->json(['success' => true, 'msg' => __('Language Deleted Successfully.')], 200);
    }

    public function changeOrderLanguage(Request $request) {
        $language = Language::where('order',$request->start_position)->first();

        if($request->start_position > $request->end_position)
        {
            for($i = $request->start_position-1; $i >= $request->end_position; $i--){
            
                $lang = Language::where('order',$i)->first();
                $lang->order = $lang->order + 1;
                if ($lang->order >= 1) {
                    $lang->save();
                }
            }
        }
        if($request->start_position < $request->end_position)
        {
            for($i = $request->start_position + 1; $i <= $request->end_position; $i++)
            {
                $lang = Language::where('order',$i)->first();
                $lang->order = $lang->order - 1;
                if ($lang->order >= 1) {
                    $lang->save();
                }
            }
        }
        $language->order = $request->end_position;
        if ($language->order >= 1) {
            $language->save();
        }
    }
}

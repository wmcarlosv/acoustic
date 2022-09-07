<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SongSection;
use App\Models\Song;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SongSectionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('song_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $song_sections = SongSection::orderBy('order','asc')->get();
        return view('admin.song_section.song_sectionTable', compact('song_sections'));
    }

    public function create()
    {
        abort_if(Gate::denies('song_section_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.song_section.song_sectionCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'title' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $section = new SongSection();
        $section->title = $request->title;
        $section->status = $request->status;

        $all = SongSection::get();
        if(count($all) == 0) {
            $section->order = 1;
        } else {
            $last_order = SongSection::orderBy('order','desc')->first();
            $section->order = $last_order->order + 1;
        }

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'Song_Section_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/song_section');
            $image->move($destinationPath, $name);
            $section->image = $name;
        }
        $section->save();
        return redirect()->route('song_section.index')->withStatus(__('Song Section Created Successfully.'));
    }

    public function edit($id)
    {
        abort_if(Gate::denies('song_section_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $song_section = SongSection::find($id);
        return view('admin.song_section.song_sectionEdit', compact('song_section'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $section = SongSection::find($id);
        $section->title = $request->title;
        $section->status = $request->status;
        
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/image/song_section/'. $section->image))){
                \File::delete(public_path('/image/song_section/'. $section->image));
            }
            $image = $request->file('image');
            $name = 'Song_Section_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/song_section');
            $image->move($destinationPath, $name);
            $section->image = $name;
        }
        $section->save();
        return redirect()->route('song_section.index')->withStatus(__('Song Section Updated Successfully.'));

    }

    public function destroy($id)
    {
        abort_if(Gate::denies('song_section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $section = SongSection::find($id);
        if(\File::exists(public_path('/image/song_section/'. $section->image))){
            \File::delete(public_path('/image/song_section/'. $section->image));
        }
        $songs = Song::get();
        foreach($songs as $song) {
            $section_id = json_decode($song->section_id);
            if(array_search($id, $section_id) !== FALSE) {
                unset($section_id[array_search($id, $section_id)]);
                $song->section_id = $section_id;
                $song->save();
            }
        }
        $section->delete();
        return response()->json(['success' => true, 'msg' => __('Song Section Deleted Successfully.')], 200);
    }
    
    public function changeOrderSongSection(Request $request) {
        $section = SongSection::where('order',$request->start_position)->first();

        if($request->start_position > $request->end_position)
        {
            for($i = $request->start_position-1; $i >= $request->end_position; $i--){
            
                $sec = SongSection::where('order',$i)->first();
                $sec->order = $sec->order + 1;
                if ($sec->order >= 1) {
                    $sec->save();
                }
            }
        }
        if($request->start_position < $request->end_position)
        {
            for($i = $request->start_position + 1; $i <= $request->end_position; $i++)
            {
                $sec = SongSection::where('order',$i)->first();
                $sec->order = $sec->order - 1;
                if ($sec->order >= 1) {
                    $sec->save();
                }
            }
        }
        $section->order = $request->end_position;
        if ($section->order >= 1) {
            $section->save();
        }
    }
}

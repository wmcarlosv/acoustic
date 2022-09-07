<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\Language;
use App\Models\SongSection;
use App\Models\SongFavorite;
use App\Models\Video;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class SongController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('song_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $songs = Song::orderBy('id','desc')->get();
        return view('admin.song.songTable', compact('songs'));
    }

    public function create()
    {
        abort_if(Gate::denies('song_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sections = SongSection::where('status',1)->orderBy('order','asc')->get(['id','title']);
        $languages = Language::where('status',1)->orderBy('order','asc')->get(['id','name']);
        return view('admin.song.songCreate',compact('sections','languages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'bail|required',
            'title' => 'bail|required',
            'artist' => 'bail|required',
            'movie' => 'bail',
            'audio' => 'bail|required',
            'duration' => 'bail|required',
            'sections' => 'bail|required',
            'language' => 'bail|required',
            'status' => 'bail|required',
        ]);
        $song = new Song();
        $song->title = $request->title;
        $song->artist = $request->artist;
        $song->movie = $request->movie;
        $song->lang = $request->language;
        $song->duration = $request->duration;
        $song->section_id = json_encode($request->sections);
        $song->status = $request->status;

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $name = 'Song_Cover_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/song');
            $image->move($destinationPath, $name);
            $song->image = $name;
        }
        
        if($request->hasFile('audio'))
        {
            $audio = $request->file('audio');
            $name = 'Song_Audio_'.uniqid().'.'. $audio->getClientOriginalExtension();
            $destinationPath = public_path('/image/song');
            $audio->move($destinationPath, $name);
            $song->audio = $name;
        }

        $song->save();
        return redirect()->route('songs.index')->withStatus(__('Song Created Successfully.'));
    }

    public function show($id)
    {
        //
    }
    
    public function edit($id)
    {
        abort_if(Gate::denies('song_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $song = Song::find($id);
        $sections = SongSection::where('status',1)->orderBy('order','asc')->get(['id','title']);
        $languages = Language::where('status',1)->orderBy('order','asc')->get(['id','name']);
        return view('admin.song.songEdit', compact('song','sections','languages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'bail|required',
            'artist' => 'bail|required',
            'movie' => 'bail',
            'language' => 'bail|required',
            'duration' => 'bail|required',
            'sections' => 'bail|required',
            'status' => 'bail|required',
        ]);

        $song = Song::find($id);
        $song->title = $request->title;
        $song->artist = $request->artist;
        $song->lang = $request->language;
        $song->movie = $request->movie;
        $song->duration = $request->duration;
        $song->section_id = json_encode($request->sections);
        $song->status = $request->status;
        if($request->hasFile('image'))
        {
            if(\File::exists(public_path('/image/song/'. $song->image))){
                \File::delete(public_path('/image/song/'. $song->image));
            }
            $image = $request->file('image');
            $name = 'Song_Cover_'.uniqid().'.'. $image->getClientOriginalExtension();
            $destinationPath = public_path('/image/song');
            $image->move($destinationPath, $name);
            $song->image = $name;
        }
        
        if($request->hasFile('audio'))
        {
            if(\File::exists(public_path('/image/song/'. $song->audio))){
                \File::delete(public_path('/image/song/'. $song->audio));
            }
            $audio = $request->file('audio');
            $name = 'Song_Audio_'.uniqid().'.'. $audio->getClientOriginalExtension();
            $destinationPath = public_path('/image/song');
            $audio->move($destinationPath, $name);
            $song->audio = $name;
        }
        $song->save();
        return redirect()->route('songs.index')->withStatus(__('Song Updated Successfully.'));

    }

    public function destroy($id)
    {
        abort_if(Gate::denies('song_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $song = Song::find($id);
        $fav = SongFavorite::where('song_id',$id)->get()->each->delete();
        $videos = Video::where('song_id',$id)->get();
        foreach ($videos as $vid) {
            $vid->song_id = null;
            $vid->save();
        }
        if(\File::exists(public_path('/image/song/'. $song->audio))){
            \File::delete(public_path('/image/song/'. $song->audio));
        }
        
        if(\File::exists(public_path('/image/song/'. $song->image))){
            \File::delete(public_path('/image/song/'. $song->image));
        }
        $song->delete();
        return response()->json(['success' => true, 'msg' => __('Song Deleted Successfully.')], 200);
    }
}

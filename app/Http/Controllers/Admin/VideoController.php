<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Gate;
use DB;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AppUser;
use App\Models\Comment;
use App\Models\AllReport;
use App\Models\Audio;
use App\Models\Saved;
use App\Models\View;
use App\Models\Notification;


class VideoController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $videos = Video::with('user')->orderBy('id','desc')->get();
        return view('admin.video.videoTable', compact('videos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        abort_if(Gate::denies('video_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $video = Video::find($id);
        $user = AppUser::with('followers','followings')->find($video->user_id);
        $post_count = Video::where([['user_id',$user->id],['is_approved',1]])->orderBy('id','desc')->count();
        $comments = Comment::with('user')->where([['video_id',$video->id]])->orderBy('id','desc')->get(['id','user_id','comment','created_at']);
        return view('admin.video.videoShow', compact('video','user','post_count','comments'));

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('video_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $video = Video::find($id);
        $allReport = AllReport::where([['type','Video'],['video_id',$id]])->get()->each->delete();
        $audios = Audio::where('video_id',$id)->get();
        foreach ($audios as $audio) {
            if(\File::exists(public_path('/image/user_audio/'. $audio->audio))){
                \File::delete(public_path('/image/user_audio/'. $audio->audio));
            }
            $audio->delete();
        }
        $likes = $video->likes()->withType(Video::class)->get()->each->delete();
        $nots = Notification::where('video_id',$id)->get()->each->delete();
        $saved = Saved::where('video_id',$id)->get()->each->delete();
        $views = View::where([['viewable_type','App\Models\Video'],['viewable_id',$id]])->get()->each->delete();

        $comments = Comment::where('video_id',$id)->get();
        foreach ($comments as $comment) {
            $allReport = AllReport::where([['type','Comment'],['comment_id',$comment->id]])->get()->each->delete();
            $nots = Notification::where('comment_id',$comment->id)->get()->each->delete();
            $likes = $comment->likes()->withType(Comment::class)->get()->each->delete();
            $comment->delete();
        }
        if(\File::exists(public_path('/image/video/'. $video->video))){
            \File::delete(public_path('/image/video/'. $video->video));
        }
        if(\File::exists(public_path('/image/video/'. $video->screenshot))){
            \File::delete(public_path('/image/video/'. $video->screenshot));
        }
        $video->delete();
        return response()->json(['success' => true, 'msg' => __('Video Deleted Successfully.')], 200);
    }
     
    public function reports_index()
    {
        abort_if(Gate::denies('video_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reports = AllReport::where('type','Video')->groupBy('video_id')->select('video_id', DB::raw('count(*) as total'))->get();
        return view('admin.video.video_reportTable', compact('reports'));
    }

    public function unapproved_index()
    {
        abort_if(Gate::denies('video_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $videos = Video::where('is_approved',0)->with('user')->get();
        return view('admin.video.videoUnapprovedTable', compact('videos'));
    }


    public function approve_video($id)
    {
        $video = Video::find($id);
        if ($video->is_approved == 0) {   
            $video->is_approved = 1;
        } else if($video->is_approved == 1) {
            $video->is_approved = 0;
        }
        $video->save();
    }

}

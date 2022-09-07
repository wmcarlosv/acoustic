<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Gate;
use DB;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Video;
use App\Models\Saved;
use App\Models\Like;
use App\Models\Audio;
use App\Models\AllReport;
use App\Models\Notification;
use App\Models\SongFavorite;
use App\Models\User_Follower;
use App\Models\Comment;
use App\Models\Block;


class AppUserController extends Controller
{
    
    public function index()
    {
        abort_if(Gate::denies('app_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $users = AppUser::orderBy('id','desc')->get();
        return view('admin.app_user.appUserTable', compact('users'));
    }
    public function show($id)
    {
        abort_if(Gate::denies('app_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $user = AppUser::with('followers','followings')->find($id);
        $posts = Video::where([['user_id',$user->id],['is_approved',1]])->orderBy('id','desc')->get(['id','song_id','audio_id','screenshot']);
        $post_count = Video::where([['user_id',$user->id],['is_approved',1]])->orderBy('id','desc')->count();
        $saved = Saved::with('video')->where('user_id',$user->id)->orderBy('id','desc')->get(['id','video_id']);
        $liked = Like::with('video')->where([['user_id',$user->id],['likeable_type','App\Models\Video']])->orderBy('id','desc')->get(['id','likeable_type','user_id','likeable_id']);
    
        return view('admin.app_user.appUserShow', compact('user','posts','post_count','saved','liked'));
    }
    
    public function reports_index()
    {
        abort_if(Gate::denies('app_user_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $reports = AllReport::where('type','User')->groupBy('user_id')->select('user_id', DB::raw('count(*) as total'))->get();
        return view('admin.app_user.appUser_reportTable', compact('reports'));
    }
    
    public function change_status($id)
    {
        $user = AppUser::find($id);
        if ($user->status == 0) {   
            $user->status = 1;
        } else if($user->status == 1) {
            $user->status = 0;
        }
        $user->save();
    }

    public function destroy($id)
    {
        $user = AppUser::with('followers','followings')->find($id);
        $allReport = AllReport::where([['type','User'],['user_id',$id]])->get()->each->delete();
        $nots = Notification::where('user_id',$id)->orWhere('friend_id',$id)->get()->each->delete();
        $saved = Saved::where('user_id',$id)->get()->each->delete();
        $songFav = SongFavorite::where('user_id',$id)->get()->each->delete();
        $block = Block::where('user_id',$id)->orWhere('blocked_id',$id)->get()->each->delete();
        $follower = User_Follower::where('following_id',$id)->orWhere('follower_id',$id)->get()->each->delete();

        $audios = Audio::where('user_id',$id)->get();
        foreach ($audios as $audio) {
            if(\File::exists(public_path('/image/user_audio/'. $audio->audio))){
                \File::delete(public_path('/image/user_audio/'. $audio->audio));
            }
            $audio->delete();
        }

        $comments = Comment::where('user_id',$id)->get();
        foreach ($comments as $comment) {
            $allReport = AllReport::where([['type','Comment'],['comment_id',$comment->id]])->get()->each->delete();
            $nots = Notification::where('comment_id',$comment->id)->get()->each->delete();
            $likes = $comment->likes()->withType(Comment::class)->get()->each->delete();
            $comment->delete();
        }

        $videos = Video::where('user_id',$id);
        foreach ($videos as $video) {
           
            $allReport = AllReport::where([['type','Video'],['video_id',$video->id]])->get()->each->delete();
            $audios = Audio::where('video_id',$video->id)->get();
            foreach ($audios as $audio) {
                if(\File::exists(public_path('/image/user_audio/'. $audio->audio))){
                    \File::delete(public_path('/image/user_audio/'. $audio->audio));
                }
                $audio->delete();
            }
            $likes = $video->likes()->withType(Video::class)->get()->each->delete();
            $nots = Notification::where('video_id',$video->id)->get()->each->delete();
            $saved = Saved::where('video_id',$video->id)->get()->each->delete();
            $views = View::where([['viewable_type','App\Models\Video'],['viewable_id',$video->id]])->get()->each->delete();

            $comments = Comment::where('video_id',$video->id)->get();
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
        }

        if($user->image != "noimage.jpg") {
            if(\File::exists(public_path('/image/user/'. $user->image))){
                \File::delete(public_path('/image/user/'. $user->image));
            }
        }
        $user->delete();
        return response()->json(['success' => true, 'msg' => __('User Deleted Successfully.')], 200);
    }

}

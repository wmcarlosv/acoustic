<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CyrildeWit\EloquentViewable\Support\Period;
use Carbon\Carbon;
use App\Models\Video;
use App\Models\View;
use App\Models\Like;
use App\Models\Song;
use App\Models\Audio;
use App\Models\Comment;
use App\Models\Challenge;
use DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.report.reportTable');
    }

    public function most_viewed_video(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }

            $views = View::whereBetween('viewed_at',[$start,$end])->get();
            $ids = array();
            foreach($views as $view) {
                array_push($ids, $view->viewable_id);
            }
            $videos = Video::with('user')->whereIn('id',$ids)->get();
            foreach($videos as $vid) {
                $vid->view_time = views($vid)->period(Period::create($start, $end))->count();
            }
        }
        else {
            $videos = Video::with('user')->orderByViews()->get();
            foreach($videos as $vid) {
                $vid->view_time = views($vid)->count();
            }
        }

        $videos = $videos->sortByDesc('view_time')->values()->take(50);

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        return view('admin.report.mostViewVideo',compact('videos','type','all_req'));
    }
    
    public function most_liked_video(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }

            $likes = Like::whereBetween('created_at',[$start,$end])->get();
            $ids = array();
            foreach($likes as $like) {
                array_push($ids, $like->likeable_id);
            }
            $videos = Video::with('user')->whereIn('id',$ids)->get();
            foreach($videos as $vid) {
                $vid->likes_count = Like::where([['likeable_type','App\Models\Video'],['likeable_id',$vid->id]])->whereBetween('created_at',[$start,$end])->count();
            }
        }
        else {
            $videos = Video::with('user')->withCount('likes')->get();
        }

        $videos = $videos->sortByDesc('likes_count')->values()->take(50);

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        return view('admin.report.mostLikeVideo',compact('videos','type','all_req'));
    }
     
    public function most_used_song(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }

            $videos = Video::whereBetween('created_at',[$start,$end])->get();
            $ids = array();
            foreach($videos as $video) {
                array_push($ids, $video->song_id);
            }
            $songs = Song::whereIn('id',$ids)->get();
            foreach($songs as $song) {
                $song->use_count = Video::where([['is_approved',1],['song_id',$song->id]])->whereBetween('created_at',[$start,$end])->count();
            }
        }
        else {
            $songs = Song::get();
            foreach($songs as $song) {
                $song->use_count = $song->songUsed;
            }
        }

        $songs = $songs->sortByDesc('use_count')->values()->take(50);

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        return view('admin.report.mostUsedSong',compact('songs','type','all_req'));
    }  

    public function most_used_audio(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }

            $videos = Video::whereBetween('created_at',[$start,$end])->get();
            $ids = array();
            foreach($videos as $video) {
                array_push($ids, $video->audio_id);
            }
            $audios = Audio::with('user','video')->whereIn('id',$ids)->get();
            foreach($audios as $audio) {
                $audio->use_count = Video::where([['is_approved',1],['audio_id',$audio->id]])->whereBetween('created_at',[$start,$end])->count();
            }
        }
        else {
            $audios = Audio::with('user','video')->get();
            foreach($audios as $audio) {
                $audio->use_count = $audio->audioUsed;
            }
        }

        $audios = $audios->sortByDesc('use_count')->values()->take(50);

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        return view('admin.report.mostUsedAudio',compact('audios','type','all_req'));
    }

    public function most_used_tag(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }

            $videos = Video::whereBetween('created_at',[$start,$end])->get();
            $comments = Comment::whereBetween('created_at',[$start,$end])->get();

            
            $tags = array();
            $video_tags = array();
            foreach($videos as $vid) {
                $all_tag = json_decode($vid->hashtags);
                foreach($all_tag as $single) {
                    if (!in_array($single, $tags)) {
                        array_push($tags,$single);
                    }
                    array_push($video_tags,$single);
                }
            }

            $comment_tags = array();
            foreach($comments as $comment) {
                $all_tag = json_decode($comment->hashtags);
                foreach($all_tag as $single) {
                    if (!in_array($single, $tags)) {
                        array_push($tags,$single);
                    }
                    array_push($comment_tags,$single);
                }
            }

            $hashtags = array();
            foreach($tags as $tag_name)
            {
                $comment_count = 0;
                $video_count = 0;

                if (in_array($tag_name, $video_tags)) {
                    $counts = array_count_values($video_tags);
                    $video_count = $counts[$tag_name];
                }
                if (in_array($tag_name, $comment_tags)) {
                    $counts = array_count_values($comment_tags);
                    $comment_count = $counts[$tag_name];
                }
                $ab['name'] = $tag_name; 
                $ab['video'] = $video_count;
                $ab['comment'] = $comment_count;
                $ab['total'] = $video_count + $comment_count;
                array_push($hashtags,$ab);
            }
           
        }
        else {
            $videos = Video::get();
            $comments = Comment::get();

            $tags = array();
            $video_tags = array();
            foreach($videos as $vid) {
                $all_tag = json_decode($vid->hashtags);
                foreach($all_tag as $single) {
                    if (!in_array($single, $tags)) {
                        array_push($tags,$single);
                    }
                    array_push($video_tags,$single);
                }
            }

            $comment_tags = array();
            foreach($comments as $comment) {
                $all_tag = json_decode($comment->hashtags);
                foreach($all_tag as $single) {
                    if (!in_array($single, $tags)) {
                        array_push($tags,$single);
                    }
                    array_push($comment_tags,$single);
                }
            }

            $hashtags = array();
            foreach($tags as $tag_name)
            {
                $comment_count = 0;
                $video_count = 0;

                if (in_array($tag_name, $video_tags)) {
                    $counts = array_count_values($video_tags);
                    $video_count = $counts[$tag_name];
                }
                if (in_array($tag_name, $comment_tags)) {
                    $counts = array_count_values($comment_tags);
                    $comment_count = $counts[$tag_name];
                }
                $ab['name'] = $tag_name; 
                $ab['video'] = $video_count;
                $ab['comment'] = $comment_count;
                $ab['total'] = $video_count + $comment_count;
                array_push($hashtags,$ab);
            }
        }

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        usort($hashtags, function($a, $b) {
            return strcmp($b['total'], $a['total']);
        });

        return view('admin.report.mostUsedTag',compact('hashtags','type','all_req'));
    }
    
    public function most_used_challenge(Request $request) {

        if(count($request->all()) != 0 && $request->type != 'all') {
          
            if ($request->type == 'day') {
                $start = $request->filter_textbox_day." 00:00:00";
                $end = $request->filter_textbox_day." 23:59:59";
            }
            elseif ($request->type == 'week') {
                $date = Carbon::parse($request->filter_textbox_week);
                $start = $date->startOfWeek()->format('Y-m-d')." 00:00:00";
                $end = $date->endOfWeek()->format('Y-m-d')." 23:59:59";
            }
            elseif ($request->type == 'month') {
                $month = $request->filter_textbox_month;
                $year = $request->filter_textbox_year;
                $start = $year.'-'.$month.'-01'.' 00:00:00';
                $end = Carbon::parse($start)->endOfMonth()->toDateString(). " 23:59:59";
            }
            elseif ($request->type == 'year') {
                $year = $request->filter_textbox_year;
                $start = $year.'-01-01'.' 00:00:00';
                $end = $year.'-12-31'.' 23:59:59';
            }
            elseif ($request->type == 'period') {
                $users = array();
                $dates = explode(' to ', $request->filter_textbox_period);
                $start = $dates[0]. " 00:00:00";
                $end = $dates[1].' 23:59:59';
            }
            
            $challanges = Challenge::get();
            foreach($challanges as $challange) {
                $vids = Video::whereBetween('created_at',[$start,$end])->get();
                $vid_ids = array();
                foreach($vids as $vid){
                    if($vid->hashtags != NULL){
                        $tags = json_decode($vid->hashtags);
                        foreach($tags as $tag) {
                            if($challange->title == $tag) {
                                if(!in_array($vid->id,$vid_ids))
                                    array_push($vid_ids,$vid->id);
                            }
                        }
                    }
                }
                $challange->used = count($vid_ids);
            }
            
        }
        else {
            $challanges = Challenge::get();
            foreach($challanges as $challange) {
                $vids = Video::get();
                $vid_ids = array();
                foreach($vids as $vid){
                    if($vid->hashtags != NULL){
                        $tags = json_decode($vid->hashtags);
                        foreach($tags as $tag) {
                            if($challange->title == $tag) {
                                if(!in_array($vid->id,$vid_ids))
                                    array_push($vid_ids,$vid->id);
                            }
                        }
                    }
                }
                $challange->used = count($vid_ids);
            }
        }
        $challanges = $challanges->sortByDesc('used')->values()->take(50);

        if(isset($request->type)) {
            $type = $request->type;
        } else {
            $type = 'all';
        }
        $all_req = $request->all();

        return view('admin.report.mostUsedChallenge',compact('challanges','type','all_req'));
    }
}

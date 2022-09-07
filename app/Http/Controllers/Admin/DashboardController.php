<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Challenge;
use App\Models\AppUser;
use App\Models\Video;
use App\Models\Song;
use App\Models\Problem;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function admin_dashboard()
    {
        abort_if(Gate::denies('admin_dashboard'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $challenge_count = Challenge::where('status',1)->count();
        $user_count = AppUser::where('status',1)->count();
        $video_count = Video::count();
        $song_count = Song::where('status',1)->count();

        $problems = Problem::orderBy('id','desc')->take(4)->get();
        $problem_count = Problem::orderBy('id','desc')->count();
        
        $challenges = Challenge::orderBy('id','desc')->where('status',1)->get();

        $fb_user = AppUser::where([['status',1],['provider','facebook']])->count();
        $google_user = AppUser::where([['status',1],['provider','google']])->count();
        $apple_user = AppUser::where([['status',1],['provider','apple']])->count();
        $local_user = AppUser::where([['status',1],['provider','local']])->count();

        $now = Carbon::now("Asia/Kolkata");
        $today_date = $now->format('Y-m-d');
        $yesterday_date = $now->subday()->format('Y-m-d');
        // Today
        $start = $today_date.' 00:00:00';
        $end = $today_date.' 23:59:59';
        $today_users = AppUser::where('status',1)
        ->whereBetween('created_at',[$start,$end])
        ->count();
        $today_videos = Video::whereBetween('created_at',[$start,$end])
        ->count();
        // Yesterday
        $start = $yesterday_date.' 00:00:00';
        $end = $yesterday_date.' 23:59:59';
        $yesterday_users = AppUser::where('status',1)
        ->whereBetween('created_at',[$start,$end])
        ->count();
        $yesterday_videos = Video::whereBetween('created_at',[$start,$end])
        ->count();
        $app_name = Setting::first()->app_name;
         
        $popular_user = AppUser::withCount('video','followers')->where('status',1)->get();
        $popular_user = collect($popular_user->toArray());
        $popular_user = $popular_user->sortByDesc('followers_count');
        $popular_user = $popular_user->values()->take(5);

        return view('admin.dashboard',
        compact('app_name','popular_user','yesterday_users','today_users','today_videos','yesterday_videos','challenges','user_count','video_count','challenge_count','song_count','problem_count','problems','fb_user','google_user','apple_user','local_user'));
    }

    public function platform()
    {
        $data['ios'] = AppUser::where([['status',1],['platform','ios']])->count();
        $data['android'] = AppUser::where([['status',1],['platform','android']])->count();

        return $data;
    }
    public function guest_user()
    {
        $data['login'] = AppUser::where('status',1)->count();
        $data['guest'] = Setting::first()->guest_user;

        return $data;
    }

    public function user_registerd_chart()
    {
        $user = array();
        $week = array();

        array_push($user,AppUser::where('status',1)
        ->whereDate('created_at', Carbon::today()->format('Y-m-d'))
        ->count());
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($user,AppUser::where('status',1)
            ->whereDate('created_at', Carbon::now()->subDays($i)->format('Y-m-d'))
            ->count());
        }

        array_push($week,Carbon::now()->format('l'));
        for ($i=1; $i <= 6 ; $i++)
        { 
            array_push($week,Carbon::now()->subDays($i)->format('l'));
        }

        return [$user,$week];
    }

    public function user_statistics(Request $request) {

        $now = Carbon::now("Asia/Kolkata");
        $today_date = $now->format('Y-m-d');

        if($request->time == "h") {
            // This hour
            $curr_start_time = $now->format('H'); 
            $start = $today_date.' '.$curr_start_time.':00:00';
            $end = $today_date.' '.$curr_start_time.':59:59';

            $user_count_curr = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();
            
            // Last hour
            $past_start = Carbon::parse($now)->subHour();
            $past_start_time = $past_start->format('H');
            $start = $today_date.' '.$past_start_time.':00:00';
            $end = $today_date.' '.$past_start_time.':59:59';
            
            $user_count_past = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();
            
            $data['user_count_curr'] = $user_count_curr;
            $data['user_text_curr'] = __("This hour");
            $data['user_count_past'] = $user_count_past;
            $data['user_text_past'] = __("Last hour");
            return $data;
        }
        
        if($request->time == "d") {
            $yesterday_date = $now->subday()->format('Y-m-d');
            // Today
            $start = $today_date.' 00:00:00';
            $end = $today_date.' 23:59:59';
            $today = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            // Yesterday
            $start = $yesterday_date.' 00:00:00';
            $end = $yesterday_date.' 23:59:59';
            $yesterday = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            $data['user_count_curr'] = $today;
            $data['user_text_curr'] = __("Today");
            $data['user_count_past'] = $yesterday;
            $data['user_text_past'] = __("Yesterday");
            return $data;
        }
        
        if($request->time == "w") {
            // This week 
            $start = $now->startOfWeek()->format('Y-m-d H:i');
            $end = $now->endOfWeek()->format('Y-m-d H:i');
            $this_week = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            // Last week
            $last_week_day = Carbon::parse($start)->subDays(1);
            $start = $last_week_day->startOfWeek()->format('Y-m-d H:i');
            $end = $last_week_day->endOfWeek()->format('Y-m-d H:i');
            $last_week = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            $data['user_count_curr'] = $this_week;
            $data['user_text_curr'] = __("This week");
            $data['user_count_past'] = $last_week;
            $data['user_text_past'] = __("Last week");
            return $data;
        }
        
        if($request->time == "m") {

            // this month
            $start = $now->startOfMonth()->format('Y-m-d H:i');
            $end = $now->endOfMonth()->format('Y-m-d H:i');
            $this_month = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            // Last month
            $start = $now->startOfMonth()->subMonth()->format('Y-m-d H:i');
            $end = $now->endOfMonth()->format('Y-m-d H:i');
            $last_month = AppUser::where('status',1)
            ->whereBetween('created_at',[$start,$end])
            ->count();

            $data['user_count_curr'] = $this_month;
            $data['user_text_curr'] = __("This month");
            $data['user_count_past'] = $last_month;
            $data['user_text_past'] = __("Last month");
            return $data;
        }
    }
    
    public function video_statistics(Request $request) {
        
        $now = Carbon::now("Asia/Kolkata");
        $today_date = $now->format('Y-m-d');

        if($request->time == "h") {

            // This hour
            $curr_start_time = $now->format('H'); 
            $start = $today_date.' '.$curr_start_time.':00:00';
            $end = $today_date.' '.$curr_start_time.':59:59';
            $video_count_curr = Video::whereBetween('created_at',[$start,$end])
            ->count();
            
            // Last hour
            $past_start = Carbon::parse($now)->subHour();
            $past_start_time = $past_start->format('H');
            $start = $today_date.' '.$past_start_time.':00:00';
            $end = $today_date.' '.$past_start_time.':59:59';
            $video_count_past = Video::whereBetween('created_at',[$start,$end])
            ->count();

            $data['video_count_curr'] = $video_count_curr;
            $data['video_text_curr'] = __("This hour");
            $data['video_count_past'] = $video_count_past;
            $data['video_text_past'] = __("Last hour");
            return $data;
        }
        
        if($request->time == "d") {
            
            $yesterday_date = $now->subday()->format('Y-m-d');
            // Today
            $start = $today_date.' 00:00:00';
            $end = $today_date.' 23:59:59';
            $today = Video::whereBetween('created_at',[$start,$end])
            ->count();

            // Yesterday
            $start = $yesterday_date.' 00:00:00';
            $end = $yesterday_date.' 23:59:59';
            $yesterday = Video::whereBetween('created_at',[$start,$end])
            ->count();

            $data['video_count_curr'] = $today;
            $data['video_text_curr'] = __("Today");
            $data['video_count_past'] = $yesterday;
            $data['video_text_past'] = __("Yesterday");
            return $data;
        }
        
        if($request->time == "w") {
            
            // This week 
            $start = $now->startOfWeek()->format('Y-m-d H:i');
            $end = $now->endOfWeek()->format('Y-m-d H:i');
            $this_week = Video::whereBetween('created_at',[$start,$end])
            ->count();

            // Last week
            $last_week_day = Carbon::parse($start)->subDays(1);
            $start = $last_week_day->startOfWeek()->format('Y-m-d H:i');
            $end = $last_week_day->endOfWeek()->format('Y-m-d H:i');
            $last_week = Video::whereBetween('created_at',[$start,$end])
            ->count();
            $data['video_count_curr'] = $this_week;
            $data['video_text_curr'] = __("This week");
            $data['video_count_past'] = $last_week;
            $data['video_text_past'] = __("Last week");
            return $data;
        }
        
        if($request->time == "m") {
            
            // this month
            $start = $now->startOfMonth()->format('Y-m-d H:i');
            $end = $now->endOfMonth()->format('Y-m-d H:i');
            $this_month = Video::whereBetween('created_at',[$start,$end])
            ->count();

            // Last month
            $start = $now->startOfMonth()->subMonth()->format('Y-m-d H:i');
            $end = $now->endOfMonth()->format('Y-m-d H:i');
            $last_month = Video::whereBetween('created_at',[$start,$end])
            ->count();

            $data['video_count_curr'] = $this_month;
            $data['video_text_curr'] = __("This month");
            $data['video_count_past'] = $last_month;
            $data['video_text_past'] = __("Last month");
            return $data;
        }
    }
}

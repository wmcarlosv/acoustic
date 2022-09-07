<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Gate;
use Illuminate\Support\Arr;
use Hash;
use Auth;
use Symfony\Component\HttpFoundation\Response;
use OneSignal;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;
use App\Mail\OTP;
use App\Models\AppUser;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Report;
use App\Models\Problem;
use App\Models\Video;
use App\Models\Audio;
use App\Models\Song;
use App\Models\User_Follower;
use App\Models\Block;
use App\Models\Notification;
use App\Models\Banner;
use App\Models\Saved;
use App\Models\SongSection;
use App\Models\Template;
use App\Models\Like;
use App\Models\AllReport;
use App\Models\Challenge;
use App\Models\SongFavorite;
use App\Models\Language;
use App\Models\View;
use App\Models\Advertisement;

class UserApiController extends Controller
{
    // Settings
    public function settings() {
        $settings = Setting::first(['app_name','project_no','app_id','app_version','app_footer','white_logo','color_logo','terms_of_use','privacy_policy',
        'is_watermark','watermark','vid_qty','share_url',
        'admob', 'android_admob_app_id', 'android_banner', 'android_interstitial', 'android_native',
        'ios_admob_app_id', 'ios_banner', 'ios_interstitial', 'ios_native','facebook','facebook_banner','facebook_init']);
        return response()->json(['msg' => 'Settings', 'data' => $settings, 'success' => true], 200);
    }

    // Advertisement
    public function advertisement() {
        $ad = Advertisement::where('status',1);

        if(Setting::first()->admob == 0)
            $ad = $ad->where('network','!=','admob');

        if(Setting::first()->facebook == 0)
            $ad = $ad->where('network','!=','facebook');

        $ad = $ad->get();
        return response()->json(['msg' => 'Advertisement', 'data' => $ad, 'success' => true], 200);
    }

    // Guest user count
    public function guest_user() {
        $settings = Setting::first();
        $settings->guest_user++;
        $settings->save();
        return response()->json(['msg' => 'Guest User', 'success' => true], 200);
    }

    // Login
    public function login(Request $request)
    {
        $request->validate([
            'login_textbox' => 'bail|required_if:provider,local,google',
            'password' => 'bail|required_if:provider,local',
            'provider' => 'bail|required',
            'provider_token' => 'bail|required_if:provider,facebook,google,apple',
            'name' => 'bail|required_if:provider,facebook,google,apple',
            'image' => 'bail|required_if:provider,facebook,google,apple',
            'platform' => 'bail|required',
        ]);

        if($request->provider == 'local') {
            $user = AppUser::where('email',$request->login_textbox)
            ->orWhere('phone',$request->login_textbox)->first();
           if($user) {
                $userdata = array(
                   'email' => $user->email,
                   'phone' => $user->phone,
                   'password' => $request->password,
                );
           }
           else {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }
            if (Auth::guard('appUser')->attempt($userdata))
            {
                $user = AppUser::find(Auth::guard('appUser')->user()->id, ['id','name','user_id','email','code','phone','is_verify','status','image']);
                if($user->status == 1)
                {
                    if($user->is_verify == 1)
                    {
                        if(isset($request->device_token)){
                            $user->device_token = $request->device_token;
                            $user->platform = $request->platform;
                            $user->save();
                        }
                        $user->token =  $user->createToken('Acoustic')->accessToken;
                        $user->setAppends(['imagePath'])->makeHidden(['platform','updated_at','device_token','status']);
                        return response()->json(['msg' => "Login successfully", 'data' => $user, 'success' => true], 200);
                    }
                    else
                    {
                        $this->send_otp($user);
                        $u['id'] = $user->id;
                        return response()->json(['msg' => "Verify your account", 'data' => $u,'success' => false], 200);
                    }
                }
                else{
                    return response()->json(['msg' => "You are blocked", 'success' => false], 200);
                }
            } else {
                return response()->json(['error' => 'Invalid email or password'], 401);
            }
        }
        else
        {
            $data = $request->all();
            $data['is_verify'] = 1;
            $filtered = Arr::except($data, ['provider_token']);
            $filtered['email'] = $data['login_textbox'];
            $user = AppUser::where('email',$data['login_textbox'])->first();
            if($user)
            {
                $user->provider_token = $request->provider_token;
                $user->save();
                $user['token'] = $user->createToken('Acoustic')->accessToken;
                return response()->json(['msg' => 'login successfully', 'data' => $user, 'success' => true], 200);
            }
            else
            {
                $filtered['user_id'] = uniqid('user_');
                $filtered['not_interested'] = '[]';

                $data = AppUser::firstOrCreate(
                    ['provider_token' => $request->provider_token],$filtered
                );
                if($request->image != null)
                {
                    $url = $request->image;
                    $contents = file_get_contents($url);
                    $name = 'user_'.uniqid().'.png';
                    $destinationPath = public_path('/image/user/'). $name;
                    file_put_contents($destinationPath, $contents);
                    $data['image'] = $name;
                }
                if(isset($data['device_token']))
                {
                    $data['device_token'] = $data->device_token;
                }
                $data->save();
                $token = $data->createToken('Acoustic')->accessToken;
                $data['token'] = $token;
                return response()->json(['msg' => 'login successfully', 'data' => $data, 'success' => true], 200);
            }
        }
    }

    // Register
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'bail|required',
            'user_id' => 'bail|required|unique:app_user',
            'email' => 'bail|required|email|unique:app_user',
            'code' => 'bail|required',
            'phone' => 'bail|required|digits:10|unique:app_user',
            'password' => 'bail|required|min:6|max:15',
            'confirm_password' => 'bail|required|same:password',
        ]);
        $verify_user = Setting::first()->is_verify;
        if($verify_user == 0) {
            $verify = 1;
        } else {
            $verify = 0;
        }
        $user = AppUser::create(
            [
                'name' => $request->name,
                'user_id' => $request->user_id,
                'email' => $request->email,
                'code' => $request->code,
                'phone' => $request->phone,
                'is_verify' => $verify,
                'provider' => 'local',
                'password' => Hash::make($request->password),
                'not_interested' => '[]',
            ]
        );
        if($user) 
        {
            if($user->is_verify == 1)
                $user['token'] = $user->createToken('Acoustic')->accessToken;
            else
                $this->send_otp($user);
            $user->setAppends([])->makeHidden(['provider','updated_at','created_at']);
            $settings = Setting::first();
            $settings->guest_user--;
            $settings->save();
            return response()->json(['success' => true, 'data' => $user, 'message' => 'User created successfully!']);
        }else {
            return response()->json(['error' => 'User not Created'], 401);
        }
    }

    // send OTP & resend OTP & forgot Password
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'bail|required|email',
        ]);
        $user = AppUser::where('email',$request->email)->first();
        if($user)
        {
            if($user->status == 1)
            {
                $this->send_otp($user);
                $send['id'] = $user->id;
                $send['name'] = $user->name;
                $send['user_id'] = $user->user_id;
                return response()->json(['msg' => 'OTP sent', 'data' => $send,'success' => true], 200);
            }
            else {
                return response()->json(['msg' => 'You are blocked by admin', 'data' => null, 'success' => false], 200);
            }
          
        }
        else{
            return response()->json(['msg' => 'User not found', 'data' => null, 'success' => false], 200);
        }
    }
    
    // Check OTP
    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => 'bail|required|digits:4',
            'user_id' => 'bail|required',
        ]);

        $user = AppUser::find($request->user_id);
        if($user->otp == $request->otp)
        {
            $user->is_verify = 1;
            $user->save();

            $data['id'] = $user->id;
            $data['name'] = $user->name;
            $data['user_id'] = $user->user_id;
            $data['token'] =  $user->createToken('Acoustic')->accessToken;

            return response()->json(['msg' => 'OTP match', 'data' => $data, 'success' => true], 200);
        }
        else{
            return response()->json(['msg' => 'Wrong OTP', 'data' => null, 'success' => false], 200);
        }
    }
    
    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
            'password' => 'bail|required|min:6|max:15',
            'confirm_password' => 'bail|required|same:password',
        ]);

        $user = AppUser::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json(['msg' => 'Password changed', 'success' => true], 200); 
    }

    // Report Reasons
    public function report_reasons($type) {
        $reports = Report::where('status',1)->orderBy('id','desc')->get(['id','reason','type']);
        $report_arr = array();
        foreach($reports as $report) {
            $arr = json_decode($report->type);
            if(in_array($type,$arr)){
                $report->makeHidden(['type']);
                array_push($report_arr,$report);
            }
        }
        return response()->json(['msg' => 'Report Reasons', 'data' => $report_arr, 'success' => true], 200);
    }
    
    // Banners
    public function banners() {
        $banners = Banner::where('status',1)->orderBy('id','desc')->get(['id','title','image','url']);
        return response()->json(['msg' => 'All Banners', 'data' => $banners, 'success' => true], 200);
    }

    // Create comment
    public function create_comment(Request $request)
    {
        $request->validate([
            'video_id' => 'bail|required|numeric',
            'comment' => 'bail|required',
        ]);
        $user1 = Auth::guard('appUserApi')->user();
        $vid = Video::find($request->video_id);
        
        if($vid->is_comment == 0)
            return response()->json(['msg' => 'No one can comment', 'success' => true], 200);

        if($vid->user->isCommentBlock)
            return response()->json(['msg' => 'You are blocked to comment', 'success' => true], 200);
       
        $my_block_users_id = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
        ->pluck('blocked_id')->toArray();

        $user_block_you = Block::where([['blocked_id',Auth::guard('appUserApi')->user()->id],['type','User']])
        ->pluck('user_id')->toArray();

        preg_match_all('/@(\w+)/',$request->comment,$matches);

        foreach($matches[0] as $item) {
            $item = str_replace('@', '', $item);
            $user = AppUser::where('user_id',$item)->first();
            if($user){
                if(in_array($user->id,$my_block_users_id)){
                    return response()->json(['msg' => 'This user is blocked by you, so you cant mention', 'success' => true], 200);
                }
                if(in_array($user->id,$user_block_you)){
                    return response()->json(['msg' => 'This user blocked you so you cant mention them', 'success' => true], 200);
                }
            }
        }

        $comment = new Comment();
        $comment->user_id = $user1->id;
        $comment->video_id = $request->video_id;
        $comment->comment = $request->comment;

        preg_match_all('/#(\w+)/',$request->comment,$matches);
        $tags = array();
        foreach($matches[0] as $item) {
            if(!in_array($item,$tags))
                array_push($tags,$item);
        }
        $comment->hashtags = json_encode($tags);
        $comment->save();

        // Tell user that in this video abc comment
        if($comment->user_id != Auth::guard('appUserApi')->user()->id){
            $template_vc = Template::where('title','Video Comment')->first();
            $detail_vc['UserName'] = $user1->name;
            $detail_vc['UserId'] = $user1->user_id;
            $data_vc = ["{UserName}","{UserId}"];
            $msg_content_vc = str_replace($data_vc, $detail_vc, $template_vc->msg_content);
            $title_vc = $template_vc->title;
    
            if($comment->video->user->mention_not == 1) 
            {
                $not_vc = new Notification(); 
                $not_vc->user_id = $user1->id;
                $not_vc->friend_id = $comment->video->user->id;
                $not_vc->video_id = $comment->video_id;
                $not_vc->comment_id = $comment->id;
                $not_vc->reason = $title_vc;
                $not_vc->msg = $msg_content_vc;
                $not_vc->save();

                try{
                    OneSignal::sendNotificationToUser(
                        $msg_content_vc,
                        $comment->video->user->device_token,
                        $url = null,
                        $data = null,
                        $buttons = null,
                        $schedule = null,
                        $title_vc
                    );
                }
                catch (\Exception $th) {}
            }
        }

        // For Mention in comments
        $mention = array();
        $template = Template::where('title','Mention Comment')->first();
        preg_match_all('/@(\w+)/',$request->comment,$matches);
        foreach($matches[0] as $item) {
            $item = str_replace('@', '', $item);
            $user2 = AppUser::where('user_id',$item)->first();
            if($user2) {
                if($user2->id != Auth::guard('appUserApi')->user()->id){
                    $detail['UserName'] = $user1->name;
                    $detail['UserId'] = $user1->user_id;
                    $data = ["{UserName}","{UserId}"];
                    $msg_content = str_replace($data, $detail, $template->msg_content);
                    $title = $template->title;
                    
                    if($user2->mention_not == 1) 
                    {
                        $not = new Notification(); 
                        $not->user_id = $user1->id;
                        $not->friend_id = $user2->id;
                        $not->video_id = $comment->video_id;
                        $not->comment_id = $comment->id;
                        $not->reason = $title;
                        $not->msg = $msg_content;
                        $not->save();

                        try{
                            OneSignal::sendNotificationToUser(
                                $msg_content,
                                $user2->device_token,
                                $url = null,
                                $data = null,
                                $buttons = null,
                                $schedule = null,
                                $title
                            );
                        }
                        catch (\Exception $th) {}
                    }
                }
            }
        }
        return response()->json(['msg' => 'Comment successfully', 'success' => true], 200);
    }

    // Delete comment
    public function delete_comment($id) {
        $comment = Comment::find($id);
        if($comment->user_id == Auth::guard('appUserApi')->user()->id || $comment->video->user->id == Auth::guard('appUserApi')->user()->id) {
            $allReport = AllReport::where([['type','Comment'],['comment_id',$id]])->get()->each->delete();
            $not = Notification::where('comment_id',$id)->get()->each->delete();
            $likes = $comment->likes()->withType(Comment::class)->get()->each->delete();
            $comment->delete();
            return response()->json(['msg' => 'Comment deleted successfully', 'success' => true], 200);
        }
        return response()->json(['msg' => 'You cant delete', 'success' => true], 200);
    }

    // Report comment
    public function report_comment(Request $request) {
        $request->validate([
            'comment_id' => 'bail|required',
            'report_id' => 'bail|required',
        ]);
        $comment = Comment::find($request->comment_id);
        if($comment->isReported)
            return response()->json(['msg' => 'Already Reported', 'success' => false], 200);

        $report = new AllReport();
        $report->report_user_id = Auth::guard('appUserApi')->user()->id;
        $report->comment_id = $comment->id;
        $report->reason_id = $request->report_id;
        $report->type = "Comment";
        $report->save();
        return response()->json(['msg' => 'Comment reported successfully', 'success' => true], 200);
    }

    // Like comment
    public function like_comment($id) {
        $user = Auth::guard('appUserApi')->user();
        $comment = Comment::find($id);
    
        $user->toggleLike($comment);
        $template = Template::where('title','Like Comment')->first();
   
        if($user->hasLiked($comment)) {
            $user->like($comment);

            $detail['UserName'] = $user->name;
            $detail['UserId'] = $user->user_id;
            $data = ["{UserName}","{UserId}"];
            $msg_content = str_replace($data, $detail, $template->msg_content);
            $title = $template->title;

            if($user->id != $comment->user_id){
                
                if($comment->user->like_not == 1) 
                {
                    $not = new Notification();
                    $not->user_id = Auth::guard('appUserApi')->user()->id;
                    $not->friend_id = $comment->user_id;
                    $not->video_id = $comment->video_id;
                    $not->comment_id = $comment->id;
                    $not->reason = $title;
                    $not->msg = $msg_content;
                    $not->save();

                    try{
                        OneSignal::sendNotificationToUser(
                            $msg_content,
                            $comment->user->device_token,
                            $url = null,
                            $data = null,
                            $buttons = null,
                            $schedule = null,
                            $title
                        );
                    }
                    catch (\Exception $th) {}
                }
            }

            return response()->json(['msg' => 'Like Comment successfully', 'success' => true], 200);
        }
        else {
            $user->unlike($comment);
            if($user->id != $comment->user_id){
                $not = Notification::where([['user_id',Auth::guard('appUserApi')->user()->id],['video_id',$comment->video_id],['friend_id',$comment->user_id],['reason',$template->title]])->first();
                $not->delete();
            }
            return response()->json(['msg' => 'Dislike Comment successfully', 'success' => true], 200);
        }
    }

    // Report Problem
    public function report_problem(Request $request) {
        $request->validate([
            'subject' => 'bail|required',
            'issue' => 'bail|required',
            'email' => 'bail|required|email',
            'imgs' => 'bail|required',
            'user_id' => 'bail',
        ]);
        $problem = new Problem();
        $problem->subject = $request->subject;
        $problem->issue = $request->issue;
        $problem->email = $request->email;
        $problem->user_id = $request->user_id;

        if(isset($request->imgs)){
            $arr = json_decode($request->imgs);
            $names = array();
            foreach($arr as $item) 
            {
                $img = $item;
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data1 = base64_decode($img);
                $name = "UserProblem_". uniqid() . ".png";
                $file = public_path('/image/user_problems/') . $name;
                $success = file_put_contents($file, $data1);
                array_push($names,$name);
            }
            $problem->ss = json_encode($names);
        }
        $problem->save();
        return response()->json(['msg' => 'Report Problem successfully', 'success' => true], 200);
    }
    
    // Trending Videos
    public function trending_video() 
    {
        $videos = Video::whereHas('user', function($query){
            $query->where('follower_request',0);
        })->where([['is_approved',1],['view','public']])
        ->inRandomOrder()
        ->get(['id','song_id','audio_id','user_id','screenshot','hashtags','video','is_comment','video','description'])
        ->makeHidden(['report','reportReasons']);
        
        if(Auth::guard('appUserApi')->check()){
            // Remove post which has not interested hashtags
            $not_interested = json_decode(Auth::guard('appUserApi')->user()->not_interested);
            $vid_ids = array();
            foreach($videos as $vid){
                $hash = json_decode($vid->hashtags);
                if(count(array_intersect($not_interested, $hash)) == 0) {
                    array_push($vid_ids, $vid->id);
                }
            }

            // Auth Followings -> videos
            $auth_followings =  Auth::guard('appUserApi')->user()->followings()->get();
            foreach($auth_followings as $followings)
            {
                if ($followings->follower_request == 0) {
                    $videos = Video::where([['user_id',$followings->id],['view','followers'],['is_approved',1]])->get();
                    foreach($videos as $vid){
                        array_push($vid_ids, $vid->id);
                    }
                }
            }

            // Remove Blocked users and Auth video
            $blocked = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->orWhere([['blocked_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->get();
            $block_ids = array();
            foreach($blocked as $block) {
                array_push($block_ids,$block->blocked_id);
                array_push($block_ids,$block->user_id);
            }

            $videos = Video::with('user')->whereIn('id',$vid_ids)
            ->whereNotIn('user_id',$block_ids)
            ->inRandomOrder()
            ->get(['id','song_id','audio_id','user_id','screenshot','hashtags','video','is_comment','video','description'])
            ->makeHidden(['report','reportReasons']);
        }

        // Removing non useable data
        foreach($videos as $vid) {
            $vid->user->makeHidden(['device_token','isReported','reportReasons','report','followersCount','followingCount','']);
        }

        return response()->json(['msg' => 'Trending Videos', 'data' => $videos, 'success' => true], 200);
    }

    // NearBy Videos
    public function nearby_video(Request $request) {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $videos = Video::with('user')->where([['is_approved',1],['view','public'],['lat','!=',null],['lang','!=',null]])
        ->get(['id','song_id','audio_id','user_id','screenshot','hashtags','video','is_comment','video','description'])
        ->makeHidden(['report','reportReasons']);
        if(Auth::guard('appUserApi')->check()) {

            Auth::guard('appUserApi')->user()->lat = $request->latitude;
            Auth::guard('appUserApi')->user()->lang = $request->longitude;
            Auth::guard('appUserApi')->user()->save();

            // Remove post which has not interested hashtags
            $not_interested = json_decode(Auth::guard('appUserApi')->user()->not_interested);
            $vid_ids = array();
            foreach($videos as $vid){
                $hash = json_decode($vid->hashtags);
                if(count(array_intersect($not_interested, $hash)) == 0) {
                    array_push($vid_ids, $vid->id);
                }
            }

            // Auth Followings -> videos
            $auth_followings =  Auth::guard('appUserApi')->user()->followings()->get();
            foreach($auth_followings as $followings){
                $videos = Video::where([['user_id',$followings->id],['view','followers'],['is_approved',1]])->get();
                foreach($videos as $vid){
                    array_push($vid_ids, $vid->id);
                }
            }

            // Remove Blocked users and Auth video
            $blocked = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->orWhere([['blocked_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->get();
            $block_ids = array();
            foreach($blocked as $block) {
                array_push($block_ids,$block->blocked_id);
                array_push($block_ids,$block->user_id);
            }

            $videos = Video::whereIn('id',$vid_ids)
            ->whereNotIn('user_id',$block_ids)
            ->get(['id','song_id','audio_id','user_id','screenshot','hashtags','video','is_comment','video','description'])
            ->makeHidden(['report','reportReasons']);
        }

        $lat1 = $request->latitude;
        $lon1 = $request->longitude;
        foreach($videos as $vid) {
            $lat2 = $vid->lat;
            $lon2 = $vid->lang;
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                $vid->distance =  0;
            } else {
                $theta = $lon1 - $lon2;
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                $dist = acos($dist);
                $dist = rad2deg($dist);
                $miles = $dist * 60 * 1.1515;
                $vid->distance = number_format(($miles * 1.609344), 2, '.', '');
            }
            $vid->user->makeHidden(['device_token','isReported','reportReasons','report','followersCount','followingCount']);
        }
        $videos = $videos->sortBy(function($video){
            return $video->distance;
        });
        $videos =  $videos->values()->all();

        return response()->json(['msg' => 'Near By Videos', 'data' => $videos, 'success' => true], 200);
    }

    // Following users video
    public function following_videos() {
        $vid_ids = array();
        $auth_followings =  Auth::guard('appUserApi')->user()->followings()->get();
        foreach($auth_followings as $followings){
            $videos = Video::where([['user_id',$followings->id],['view','followers'],['is_approved',1]])
            ->orWhere([['user_id',$followings->id],['view','public'],['is_approved',1]])
            ->get();
            foreach($videos as $vid) {
                array_push($vid_ids, $vid->id);
            }
        }
        
        $videos = Video::with('user')->whereIn('id',$vid_ids)
        ->orderBy('id','desc')
        ->get(['id','song_id','audio_id','video','description','user_id','is_comment','screenshot','hashtags','video','description'])
        ->makeHidden(['report','reportReasons']);

        foreach($videos as $video) {
            $video->user->makeHidden('device_token','followersCount','followingCount','isReported','report','reportReasons');
        }

        return response()->json(['msg' => 'Following users Videos', 'data' => $videos, 'success' => true], 200);
    }

    // Single Video
    public function single_video($id) {
       
        $video = Video::with('user')->find($id,['id','song_id','audio_id','video','description','user_id','is_comment','view'])
        ->makeHidden(['updated_at','report','reportReasons']);

        $video->user->makeHidden('device_token','followersCount','followingCount','isReported','report','reportReasons');
    
        return response()->json(['msg' => 'Single Video', 'data' => $video, 'success' => true], 200);
    }

    public function video_view($id) {
        $video = Video::find($id);
        $hasAlredyView = View::where([['viewable_type','App\Models\Video'],['viewable_id',$video->id],['visitor',request()->ip()]])->first();
        if(!$hasAlredyView) {
            views($video)->record();
            return response()->json(['msg' => 'Video Viewd', 'success' => true], 200);
        } else {
            return response()->json(['msg' => 'Already Viewed', 'success' => true], 200);
        }
    }

    // single_video_comments
    public function single_video_comments($id) {
        $comments = Comment::with('user')->where('video_id',$id)->orderBy('id','desc')
        ->get(['id','user_id','comment','created_at','video_id'])
        ->makeHidden(['created_at','report','reportReasons']);

        foreach($comments as $comment) {
            $comment->user->makeHidden('device_token','like_not','isFollowing','followersCount','followingCount','isReported','report','reportReasons','isCommentBlock');
        }

        return response()->json(['msg' => 'All Comments of a video', 'data' => $comments, 'success' => true], 200);
    }

  // Upload Video
  public function upload_video(Request $request) {

    $request->validate([
        'video' => 'bail|required',
        'screenshot' => 'bail|required',
        'view' => 'bail|required',
        'is_comment' => 'bail|required',
    ]);

    $user1 = Auth::guard('appUserApi')->user();
    if($request->song_id == null && $request->audio_id == null) {
        $request->validate([
            'audio' => 'bail|required',
            'duration' => 'bail|required',
            'language' => 'bail|required',
        ]);
    }

    $vid = new Video();
    $vid->user_id = $user1->id;

    if(isset($request->song_id))
    {
        $vid->song_id = $request->song_id;
        $song = Song::find($request->song_id);
        $vid->language = $song->lang;
    }
    elseif(isset($request->audio_id))
    {
        $vid->audio_id = $request->audio_id;
        $audio = Audio::find($request->audio_id);
        $vid->language = $audio->lang;
    }
    elseif(isset($request->audio))
    {
        $new = new Audio();
        $audio = $request->audio;
        $audio = str_replace('data:video/wav;base64,', '', $audio);
        $audio = str_replace(' ', '+', $audio);
        $data1 = base64_decode($audio);
        $name = "Audio_". uniqid() . ".mp3";
        $file = public_path('/image/user_audio/') . $name;
        $success = file_put_contents($file, $data1);

        $new->audio = $name;
        $new->user_id = $user1->id;
        $new->duration = $request->duration;
        $new->lang = $request->language;
        $new->save();
        $vid->audio_id = $new->id;
        $vid->language = $request->language;
    }
    else {
        return response()->json(['msg' => 'give song_id audio_id or audio', 'success' => false], 400);
    }
    if($request->file('video'))
    {
        $file = $request->file('video');
        $name = "Video_". uniqid() .".". $file->getClientOriginalExtension();
        $file->move(public_path('/image/video/'),$name);
        $vid->video = $name;
    }
    if(isset($request->screenshot))
    {
        $ss = $request->screenshot;
        $ss = str_replace('data:image/wav;base64,', '', $ss);
        $ss = str_replace(' ', '+', $ss);
        $data1 = base64_decode($ss);
        $name = "Video_SS_". uniqid() . ".png";
        $file = public_path('/image/video/') . $name;
        $success = file_put_contents($file, $data1);
        $vid->screenshot = $name;
    }
    
    $vid->is_approved = Setting::first()->auto_approve;
    if($request->description != null) {
        $vid->description = $request->description;
        preg_match_all('/#(\w+)/',$request->description,$matches);
        $tags = array();
        foreach($matches[0] as $item) {
            if(!in_array($item,$tags))
                array_push($tags,$item);
        }
        $vid->hashtags = json_encode($tags);
        
        preg_match_all('/@(\w+)/',$request->description,$matches);
        $user_tags = array();
        foreach($matches[0] as $item) {
            if(!in_array($item,$user_tags))
                array_push($user_tags,$item);
        }
        $vid->user_tags = json_encode($user_tags);
    }
    $vid->view = $request->view;
    $vid->is_comment = $request->is_comment;
    if($vid->hashtags == null){
        $vid->hashtags = '[]';
    }
    $vid->save();
    if (isset($request->audio)) {
        $new->video_id = $vid->id;
        $new->save();
    }

    // send Notification
    if($request->description != null)
    {
        $template = Template::where('title','Mention Video')->first();
        foreach($user_tags as $item) {
            $item = str_replace('@', '', $item);
            $user2 = AppUser::where('user_id',$item)->first();
            if($user2) {
                if($user2->id != Auth::guard('appUserApi')->user()->id) {
                    $detail['UserName'] = $user1->name;
                    $detail['UserId'] = $user1->user_id;
                    $data = ["{UserName}","{UserId}"];
                    $msg_content = str_replace($data, $detail, $template->msg_content);
                    $title = $template->title;
                    
                    
                    if($user2->mention_not == 1) 
                    {
                        $not = new Notification();
                        $not->user_id = $user1->id;
                        $not->friend_id = $user2->id;
                        $not->video_id = $vid->id;
                        $not->reason = $title;
                        $not->msg = $msg_content;
                        $not->save();

                        try{
                            OneSignal::sendNotificationToUser(
                                $msg_content,
                                $user2->device_token,
                                $url = null,
                                $data = null,
                                $buttons = null,
                                $schedule = null,
                                $title
                            );
                        }
                        catch (\Exception $th) {}
                    }
                }
            }
        }
    }

    return response()->json(['msg' => 'Video Uploaded successfully', 'data' => $vid, 'success' => true], 200);

}
    
    // Edit Video
    public function edit_video(Request $request) {
        $request->validate([
            'video_id' => 'bail|required',
            'view' => 'bail|required',
            'is_comment' => 'bail|required',
        ]);
        $vid = Video::find($request->video_id);
        $user1 = Auth::guard('appUserApi')->user();
        $template = Template::where('title','Mention Video')->first();

        $user_tags = array();
        $vid->description = $request->description;
        if($request->description != null) {

            preg_match_all('/#(\w+)/',$request->description,$matches);
            $tags = array();
            foreach($matches[0] as $item) {
                if(!in_array($item,$tags))
                    array_push($tags,$item);
            }
            $vid->hashtags = json_encode($tags);

            preg_match_all('/@(\w+)/',$request->description,$matches);
            foreach($matches[0] as $item) {
                if(!in_array($item,$user_tags))
                    array_push($user_tags,$item);
            }
        }
        $vid->view = $request->view;
        $vid->is_comment = $request->is_comment;

        $new = $user_tags;
        $old = json_decode($vid->user_tags);
        $result = array_diff($old,$new);
        foreach($result as $item) {
            $item = str_replace('@', '', $item);
            $user2 = AppUser::where('user_id',$item)->first();
            if($user2) {
                $not_found = Notification::where([['user_id',$user1->id],['friend_id',$user2->id],['reason',$template->title]])->delete();
            }
        }
        // send Notification
        if($request->description != null)
        {
            foreach($user_tags as $item) {
                $item = str_replace('@', '', $item);
                $user2 = AppUser::where('user_id',$item)->first();
                if($user2) {
                    if($user2->id != Auth::guard('appUserApi')->user()->id){
                        $not_found = Notification::where([['user_id',$user1->id],['friend_id',$user2->id],['reason',$template->title]])->first();
                        if(!$not_found)
                        {
                            $detail['UserName'] = $user1->name;
                            $detail['UserId'] = $user1->user_id;
                            $data = ["{UserName}","{UserId}"];
                            $msg_content = str_replace($data, $detail, $template->msg_content);
                            $title = $template->title;
                            
                            if($user2->mention_not == 1)
                            {
                                $not = new Notification();
                                $not->user_id = $user1->id;
                                $not->friend_id = $user2->id;
                                $not->video_id = $vid->id;
                                $not->reason = $title;
                                $not->msg = $msg_content;
                                $not->save();

                                try{
                                    OneSignal::sendNotificationToUser(
                                        $msg_content,
                                        $user2->device_token,
                                        $url = null,
                                        $data = null,
                                        $buttons = null,
                                        $schedule = null,
                                        $title
                                    );
                                }
                                catch (\Exception $th) {}
                            }
                        }
                    }
                }
            }
        }

        $vid->user_tags = json_encode($user_tags);
        $vid->save();
        return response()->json(['msg' => 'Video Updated successfully', 'data' => $vid, 'success' => true], 200);
    }

    // delete Video
    public function delete_video($id) {
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
        return response()->json(['msg' => 'Video deleted successfully', 'success' => true], 200);
    }

    // Report Video
    public function report_video(Request $request) {
        $request->validate([
            'video_id' => 'bail|required',
            'report_id' => 'bail|required',
        ]);
        $video = Video::find($request->video_id);
        if($video->isReported)
            return response()->json(['msg' => 'Already Reported', 'success' => false], 200);
              
        $report = new AllReport();
        $report->report_user_id = Auth::guard('appUserApi')->user()->id;
        $report->video_id = $video->id;
        $report->reason_id = $request->report_id;
        $report->type = "Video";
        $report->save();
        return response()->json(['msg' => 'Video reported successfully', 'success' => true], 200);
    }

    // Like Video 
    public function like_video($id) {
        $user = Auth::guard('appUserApi')->user();
        $video = Video::find($id);
        $user->toggleLike($video);

        $template = Template::where('title','Like Video')->first();
   
        if($user->hasLiked($video)) {
            $user->like($video);

            $detail['UserName'] = $user->name;
            $detail['UserId'] = $user->user_id;
            $data = ["{UserName}","{UserId}"];
            $msg_content = str_replace($data, $detail, $template->msg_content);
            $title = $template->title;

            if($user->id != $video->user_id)
            { 
                if($video->user->like_not == 1) 
                {
                    $not = new Notification();
                    $not->user_id = Auth::guard('appUserApi')->user()->id;
                    $not->friend_id = $video->user_id;
                    $not->video_id = $video->id;
                    $not->reason = $title;
                    $not->msg = $msg_content;
                    $not->save();
                    
                    try{
                        OneSignal::sendNotificationToUser(
                            $msg_content,
                            $video->user->device_token,
                            $url = null,
                            $data = null,
                            $buttons = null,
                            $schedule = null,
                            $title
                        );
                    }
                    catch (\Exception $th) {}
                }
            }
            $data_send['like_count'] = $video->likeCount;
            $data_send['isLike'] = $user->hasLiked($video);
            return response()->json(['msg' => 'Like Video successfully','data' => $data_send ,'success' => true], 200);
        }
        else {
            $user->unlike($video);
            if($user->id != $video->user_id)
            {
                $not = Notification::where([['user_id',Auth::guard('appUserApi')->user()->id],['video_id',$video->id],['friend_id',$video->user_id],['reason',$template->title]])->first();
                if ($not)
                    $not->delete();
            }
            $data_send['like_count'] = $video->likeCount;
            $data_send['isLike'] = $user->hasLiked($video);
            return response()->json(['msg' => 'Dislike Video successfully','data' => $data_send, 'success' => true], 200);
        }
    }
    
    // Like Video
    public function save_video($id) {
        $found = Saved::where([['user_id',Auth::guard('appUserApi')->user()->id],['video_id',Video::find($id)->id]])->first();
        if($found){
            $found->delete();
            return response()->json(['msg' => 'Video Removed from Saved successfully', 'success' => true], 200);
        } else {
            $save = new Saved();
            $save->user_id = Auth::guard('appUserApi')->user()->id;
            $save->video_id = Video::find($id)->id;
            $save->save();
            return response()->json(['msg' => 'Video Saved successfully', 'success' => true], 200);
        }
    }

    // Follow
    public function follow($id)
    {
        $user1 = Auth::guard('appUserApi')->user();
        $user2 = AppUser::find($id);
        if($user1->id == $id){
            return response()->json(['msg' => 'You cant follow yourself', 'success' => true], 200);
        }
        if($user1->isFollowing($user2)) {
            return response()->json(['msg' => 'You are already following this user', 'success' => true], 200);
        }

        $found = User_Follower::where([['follower_id',$user1->id],['following_id',$user2->id],['accepted_at',null]])->first();
        if($found) {
            return response()->json(['msg' => 'Please Wait to accept your request', 'success' => true], 200);
        }
        else {
            $user1->follow($user2);
            if($user2->follower_request == 0) {
                // Follow
                $template = Template::where('title','Follow')->first();
                $detail['UserName'] = $user1->name;
                $detail['UserId'] = $user1->user_id;
                $data = ["{UserName}","{UserId}"];
                $msg_content = str_replace($data, $detail, $template->msg_content);
                $title = $template->title;
                if($user2->follow_not == 1) 
                {
                    $not = new Notification();
                    $not->user_id = Auth::guard('appUserApi')->user()->id;
                    $not->friend_id = $user2->id;
                    $not->reason = $title;
                    $not->msg = $msg_content;
                    $not->save();
                    try{
                        OneSignal::sendNotificationToUser(
                            $msg_content,
                            $user2->device_token,
                            $url = null,
                            $data = null,
                            $buttons = null,
                            $schedule = null,
                            $title
                        );
                    }
                    catch (\Exception $th) {}
                }
                return response()->json(['msg' => 'Followed Successfully', 'success' => true], 200);
            } else {
                // Request
                $template = Template::where('title','Request')->first();
                $detail['UserName'] = $user1->name;
                $detail['UserId'] = $user1->user_id;
                $data = ["{UserName}","{UserId}"];
                $msg_content = str_replace($data, $detail, $template->msg_content);
                $title = $template->title;
                if (!Notification::where([['user_id',Auth::guard('appUserApi')->user()->id],['friend_id',$user2->id],['reason',$title]])->exists()) {
                    $not = new Notification();
                    $not->user_id = Auth::guard('appUserApi')->user()->id;
                    $not->friend_id = $user2->id;
                    $not->reason = $title;
                    $not->msg = $msg_content;
                    $not->save();
    
                    if($user2->request_not == 1) 
                    {
                        try{
                            OneSignal::sendNotificationToUser(
                                $msg_content,
                                $user2->device_token,
                                $url = null,
                                $data = null,
                                $buttons = null,
                                $schedule = null,
                                $title
                            );
                        }
                        catch (\Exception $th) {}
                    }
                }
                return response()->json(['msg' => 'Request Sent', 'success' => true], 200);
            }
        }
    }
     
    // Unfollow
    public function unfollow($id){
        $user1 = Auth::guard('appUserApi')->user();
        $user2 = AppUser::find($id);
        $user1->unfollow($user2); 
        return response()->json(['msg' => 'Unfollowed Successfully', 'success' => true], 200);
    }

    // Accept Request
    public function accept($id)
    {
        $user1 = Auth::guard('appUserApi')->user();
        $user2 = AppUser::find($id);
        $user1->acceptFollowRequestFrom($user2);

        $template = Template::where('title','Follow')->first();
        $detail['UserName'] = $user1->name;
        $detail['UserId'] = $user1->user_id;
        $data = ["{UserName}","{UserId}"];
        $msg_content = str_replace($data, $detail, $template->msg_content);
        $title = $template->title;

        $remove_request = Notification::where([['user_id',$id],['friend_id',$user1->id],['reason','Request']])->first();
        if(isset($remove_request)){
            $remove_request->delete();
        }
        
        if($user2->follow_not == 1) 
        {
            $not = new Notification();
            $not->user_id = Auth::guard('appUserApi')->user()->id;
            $not->friend_id = $user2->id;
            $not->reason = $title;
            $not->msg = $msg_content;
            $not->save();

            try{
                OneSignal::sendNotificationToUser(
                    $msg_content,
                    $user2->device_token,
                    $url = null,
                    $data = null,
                    $buttons = null,
                    $schedule = null,
                    $title
                );
            }
            catch (\Exception $th) {}
        }
        return response()->json(['msg' => 'Follow Request Accepted', 'success' => true], 200);
    }
    
    // Reject Request
    public function reject($id)
    {
        $user1 = Auth::guard('appUserApi')->user();
        $user2 = AppUser::find($id);
        $user2->rejectFollowRequestFrom($user1);

        $remove_request = Notification::where([['user_id',$id],['friend_id',$user1->id],['reason','Request']])->first();
        if(isset($remove_request)){
            $remove_request->delete();
        }
        return response()->json(['msg' => 'Follow Request Rejected', 'success' => true], 200);
    }

    // Block user
    public function block(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required',
            'type' => 'bail|required',
        ]);
        if($request->user_id != Auth::guard('appUserApi')->user()->id)
        {
            $found = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['blocked_id',$request->user_id],['type',$request->type]])->first();
            if($request->type == "User"){
                if($found){
                    return response()->json(['msg' => 'User Already Blocked', 'success' => true], 200);
                }
                
                $block = new Block();
                $block->user_id = Auth::guard('appUserApi')->user()->id;
                $block->blocked_id = $request->user_id;
                $block->type = "User";
                $block_user = AppUser::find($request->user_id);
                if(Auth::guard('appUserApi')->user()->isFollowing($block_user))
                {
                    Auth::guard('appUserApi')->user()->unfollow($block_user);
                }
                if($block_user->isFollowing(Auth::guard('appUserApi')->user()))
                {
                    $block_user->unfollow(Auth::guard('appUserApi')->user());
                }
                $block->save();
    
                // Remove likes
                $likes = Like::with('video')->where([['user_id',Auth::guard('appUserApi')->user()->id],['likeable_type','App\Models\Video']])->get();
                foreach ($likes as $item) {
                    if ($item->video->user_id == $request->user_id) {
                        $item->delete();
                    }
                }
                $likes2 = Like::with('video')->where([['user_id',$request->user_id],['likeable_type','App\Models\Video']])->get();
                foreach ($likes2 as $item) {
                    if ($item->video->user_id == Auth::guard('appUserApi')->user()->id){
                        $item->delete();
                    }
                }
    
                // Remove Saved
                $saved = Saved::with('video')->where('user_id',Auth::guard('appUserApi')->user()->id)->get();
                foreach ($saved as $item) {
                    if ($item->video->user_id == $request->user_id) {
                        $item->delete();
                    }
                }
                $saved2 = Saved::with('video')->where('user_id',$request->user_id)->get();
                foreach ($saved2 as $item) {
                    if ($item->video->user_id == Auth::guard('appUserApi')->user()->id){
                        $item->delete();
                    }
                }
                return response()->json(['msg' => 'User Blocked successfully', 'success' => true], 200);
            }
            if($request->type == "Comment") {
                if($found){
                    return response()->json(['msg' => 'User Already Blocked for Comments', 'success' => true], 200);
                }
                $block = new Block();
                $block->user_id = Auth::guard('appUserApi')->user()->id;
                $block->blocked_id = $request->user_id;
                $block->type = "Comment";
                $block_user = AppUser::find($request->user_id);
                $block->save();
                return response()->json(['msg' => 'User Blocked for Comments successfully', 'success' => true], 200);
            }
        }
        else
            return response()->json(['msg' => 'You Can not Block your self.', 'success' => false]);
    }

    // Unblock User
    public function unblock(Request $request) {
        $request->validate([
            'user_id' => 'bail|required',
            'type' => 'bail|required',
        ]);
        $unblock = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['blocked_id',$request->user_id],['type',$request->type]])->first();
        if($unblock) {
            $unblock->delete();
            return response()->json(['msg' => 'User Unblock successfully', 'success' => true], 200);
        }
        return response()->json(['msg' => 'User not blocked...!!!!', 'success' => false], 200);
    }

    // Block List Users
    public function users_block_list()
    {
        $block_users_id = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
        ->pluck('blocked_id')->toArray();

        $block_users = AppUser::whereIn('id',$block_users_id)
        ->get(['id','name','user_id','image'])
        ->each->setAppends(['imagePath']);

        return response()->json(['msg' => 'Blocked Users','data' => $block_users, 'success' => true], 200);
    }
    
    // Block List Comments
    public function comments_block_list()
    {
        $block_users_id = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','Comment']])
        ->pluck('blocked_id')->toArray();

        $block_comments = AppUser::whereIn('id',$block_users_id)
        ->get(['id','name','user_id','image'])
        ->each->setAppends(['imagePath']);

        return response()->json(['msg' => 'Comments Blocked of this users','data' => $block_comments, 'success' => true], 200);
    }
    
    // Remove user from following you
    public function remove_follow($id) {
        $user1 = AppUser::find($id);
        $user2 = Auth::guard('appUserApi')->user();
        $user1->unfollow($user2);
        return response()->json(['msg' => 'Remove from following Successfully', 'success' => true], 200);
    }

    // Not interested
    public function not_interested($id) {
        $vid = Video::find($id);
        preg_match_all('/(?!\b)(#\w+\b)/',$vid->description,$matches);
        $tags = json_decode(Auth::guard('appUserApi')->user()->not_interested);
        foreach($matches[0] as $item) {
            if (!in_array($item, $tags))
                array_push($tags,$item);
        }
        Auth::guard('appUserApi')->user()->not_interested = json_encode($tags);
        Auth::guard('appUserApi')->user()->save();

        return response()->json(['msg' => "we'll show fewer videos like this from now on", 'success' => true], 200);
    }

    // suggestions while type @
    public function user_suggestion($query) {
        $user = AppUser::where([['name', 'like', '%' . $query . '%'],['status',1]])
        ->orWhere([['user_id', 'like', '%' . $query . '%'],['status',1]])
        ->get(['id','image','name','user_id'])
        ->each->setAppends(['imagePath','isFollowing'])
        ->sortByDesc('isFollowing')->values()->all();

        return response()->json(['msg' => 'User Suggestions', 'data' => $user, 'success' => true], 200);
    }
    
    // suggestions while type #
    public function hashtag_suggestion($query) {
        $videos = Video::get(['id','hashtags','song_id','audio_id']);
        $comments = Comment::get();
        $tags = array();
        foreach($videos as $vid) {
            $all_tag = json_decode($vid->hashtags);
            foreach($all_tag as $single) {
                if(stripos($single,$query))
                    array_push($tags,$single);
            }
        }
        foreach($comments as $comment) {
            $all_tag = json_decode($comment->hashtags);
            foreach($all_tag as $single) {
                if(stripos($single,$query))
                    array_push($tags,$single);
            }
        }
        $tags = array_count_values($tags);
        arsort($tags);
        $arr = array();
        foreach($tags as $key => $tag)
        {
            $ab['tag'] = $key;
            $n = $tag;

            $precision = 1;

            if ($n < 900) {
                // 0 - 900
                $n_format = number_format($n, $precision);
                $suffix = '';
            } else if ($n < 900000) {
                // 0.9k-850k
                $n_format = number_format($n / 1000, $precision);
                $suffix = 'K';
            } else if ($n < 900000000) {
                // 0.9m-850m
                $n_format = number_format($n / 1000000, $precision);
                $suffix = 'M';
            } else if ($n < 900000000000) {
                // 0.9b-850b
                $n_format = number_format($n / 1000000000, $precision);
                $suffix = 'B';
            } else {
                // 0.9t+
                $n_format = number_format($n / 1000000000000, $precision);
                $suffix = 'T';
            }
        
            if ( $precision > 0 ) {
                $dotzero = '.' . str_repeat( '0', $precision );
                $n_format = str_replace( $dotzero, '', $n_format );
            }
            $ab['use'] = $n_format . $suffix;


            array_push($arr,$ab);
        }
        return response()->json(['msg' => 'Default search Hashtags suggestions', 'data' => $arr, 'success' => true], 200);
    }

    // Search
     public function search($query) {
        $data['creators'] = AppUser::where('name', 'like', '%' . $query . '%')
        ->orWhere('user_id', 'like', '%' . $query . '%')
        ->get(['id','image','name','user_id'])
        ->makeHidden(['followingCount','isCommentBlock','isReported','reportReasons','report']);

        $videos = Video::get(['id','hashtags','song_id','audio_id']);
        $tags = array();

        foreach($videos as $vid){
            $all_tag = json_decode($vid->hashtags);
            foreach($all_tag as $single){
                array_push($tags,$single);
            }
        }

        $tags = array_count_values($tags);
        arsort($tags);
        $arr = array();
        foreach($tags as $key => $tag)
        {
            if(stripos($key, $query) == 1){

                $key = ltrim($key, '#');
                $ab['tag'] = $key;
                $n =  $tag;
                $precision = 1;

                if ($n < 900) {
                    // 0 - 900
                    $n_format = number_format($n, $precision);
                    $suffix = '';
                } else if ($n < 900000) {
                    // 0.9k-850k
                    $n_format = number_format($n / 1000, $precision);
                    $suffix = 'K';
                } else if ($n < 900000000) {
                    // 0.9m-850m
                    $n_format = number_format($n / 1000000, $precision);
                    $suffix = 'M';
                } else if ($n < 900000000000) {
                    // 0.9b-850b
                    $n_format = number_format($n / 1000000000, $precision);
                    $suffix = 'B';
                } else {
                    // 0.9t+
                    $n_format = number_format($n / 1000000000000, $precision);
                    $suffix = 'T';
                }

                if ( $precision > 0 ) {
                    $dotzero = '.' . str_repeat( '0', $precision );
                    $n_format = str_replace( $dotzero, '', $n_format );
                }

                $ab['use'] = $n_format . $suffix;
                array_push($arr,$ab);
            }
        }

        $data['hashtags'] = $arr;
        return response()->json(['msg' => 'Default search creators suggestions', 'data' => $data, 'success' => true], 200);
    }

    // Default search screen
    public function search_default() {
        $challanges = Challenge::where('status',1)->get(['id','title','image'])->each->setAppends(['imagePath']);
        if(Auth::guard('appUserApi')->check())
        {
            $followings =  Auth::guard('appUserApi')->user()->followings;
            $arrr = array();
            foreach($followings as $item){
                array_push($arrr, $item->id);
            }

            $videos1 = Video::where([['is_approved',1],['view','followers']])
            ->whereIn('user_id',$arrr)
            ->get(['id','user_id','hashtags','song_id','audio_id','view']);

            $videos2 = Video::where([['is_approved',1],['view','public']])
            ->get(['id','hashtags','song_id','audio_id','screenshot']);

            $videos = $videos1->merge($videos2);
        }
        else {
            $videos = Video::where([['is_approved',1],['view','public']])
            ->get(['id','hashtags','song_id','audio_id','screenshot']);
        }
        $videos = $videos->sortByDesc('viewCount')->values()->all();
        $min_trending = Setting::first()->trending_challenge;
        foreach($challanges as $challange) {
            $vid_arr = array();
            $views = 0;
            foreach($videos as $vid) {
                $all_tag = json_decode($vid->hashtags);
                if(in_array($challange->title,$all_tag)) {
                    $vid->setAppends(['imagePath','viewCount'])->makeHidden(['hashtags','song_id','audio_id']);
                    array_push($vid_arr,$vid);
                    $views = $views+$vid->viewCount;
                    $view_int =  $views;
                    $n =  $views;
                    $precision = 1;
                    if ($n < 900) {
                        // 0 - 900
                        $n_format = number_format($n, $precision);
                        $suffix = '';
                    } else if ($n < 900000) {
                        // 0.9k-850k
                        $n_format = number_format($n / 1000, $precision);
                        $suffix = 'K';
                    } else if ($n < 900000000) {
                        // 0.9m-850m
                        $n_format = number_format($n / 1000000, $precision);
                        $suffix = 'M';
                    } else if ($n < 900000000000) {
                        // 0.9b-850b
                        $n_format = number_format($n / 1000000000, $precision);
                        $suffix = 'B';
                    } else {
                        // 0.9t+
                        $n_format = number_format($n / 1000000000000, $precision);
                        $suffix = 'T';
                    }
                
                    if ( $precision > 0 ) {
                        $dotzero = '.' . str_repeat( '0', $precision );
                        $n_format = str_replace( $dotzero, '', $n_format );
                    }
                    $views = $n_format . $suffix;
                }
            }
            $challange->videos = $vid_arr;
            $challange->views = $views;
            if($view_int >= $min_trending) {
                $challange->trending = 1;
            } else {
                $challange->trending = 0;
            }
            $challange->title = ltrim($challange->title, '#');
        }
        $send = $challanges->sortByDesc('views')->values()->all();

        return response()->json(['msg' => 'Challanges', 'data' => $send, 'success' => true], 200);
    }

    // Hashtags Videos
    public function hashtag_videos($hashtag)
    {
        if(Auth::guard('appUserApi')->check())
        {
            $followings =  Auth::guard('appUserApi')->user()->followings;
            $arrr = array();
            foreach($followings as $item){
                array_push($arrr, $item->id);
            }

            $videos1 = Video::where([['is_approved',1],['view','followers']])
            ->whereIn('user_id',$arrr)
            ->get(['id','user_id','hashtags','song_id','audio_id','view']);

            $videos2 = Video::where([['is_approved',1],['view','public']])
            ->get(['id','hashtags','song_id','audio_id']);

            $videos = $videos1->merge($videos2);
        }
        else {
            $videos = Video::where([['is_approved',1],['view','public']])
            ->get(['id','hashtags','song_id','audio_id']);
        }
        $vid_ids = array();
        foreach($videos as $vid){
            $all_tag = json_decode($vid->hashtags);
            foreach($all_tag as $single) {
                if($single == '#'.$hashtag) {
                    array_push($vid_ids,$vid->id);
                }
            }
        }
        $vids = Video::with('user')->whereIn('id',$vid_ids)
        ->get(['id','user_id','song_id','audio_id','screenshot'])
        ->makeHidden(['song_id','audio_id'])
        ->each->setAppends(['isLike','imagePath','viewCount']);

        foreach($vids as $vid) {
            $vid->view_count = views($vid)->count();
        }

        $vids = $vids->sortByDesc('view_count')->makeHidden('view_count')->values()->all();

        foreach($vids as $vid){
            $vid->user->setAppends(['imagePath'])->makeHidden('device_token');
        }

        return response()->json(['msg' => 'Hashtag videos', 'data' => $vids, 'success' => true], 200);
    }

    public function single_user($id)
    {
        // follow_request == 0 public , 1 private
        $user = AppUser::find($id,['id','user_id','name','image','bio','follower_request'])->makeHidden(['isCommentBlock','report','reportReasons']);

        if (Auth::guard('appUserApi')->check()) 
        {
            if ($user->follower_request == 1 && $user['isFollowing'] == 1)
            {
                // if follower_request value is 0 than videos display in App
                $user->follower_request = 0;
                $user->videos = Video::where([['is_approved',1],['user_id',$user->id],['view','!=','private']])
                ->get(['id','song_id','audio_id','screenshot'])
                ->each->setAppends(['imagePath','isLike','viewCount'])
                ->makeHidden(['song_id','audio_id']);
            }
            else
            {
                if ($user->follower_request == 0)
                {
                    $user->videos = Video::where([['is_approved',1],['user_id',$user->id],['view','!=','private']])
                    ->get(['id','song_id','audio_id','screenshot'])
                    ->each->setAppends(['imagePath','isLike','viewCount'])
                    ->makeHidden(['song_id','audio_id']);
                }
                else
                {
                    $user->videos = array();
                }
            }
        }
        else
        {
            if ($user->follower_request == 0)
            {
                $user->videos = Video::where([['is_approved',1],['user_id',$user->id],['view','!=','private']])
                ->get(['id','song_id','audio_id','screenshot'])
                ->each->setAppends(['imagePath','isLike','viewCount'])
                ->makeHidden(['song_id','audio_id']);
            }
        }

        // if(Auth::guard('appUserApi')->check() && Auth::guard('appUserApi')->user()->isFollowing($user))
        // {
        //     $user->videos = Video::where([['is_approved',1],['user_id',$user->id],['view','!=','private']])
        //     ->get(['id','song_id','audio_id','screenshot'])
        //     ->each->setAppends(['imagePath','isLike','viewCount'])
        //     ->makeHidden(['song_id','audio_id']);
        // }
        // else {
        //     $user->videos = Video::where([['is_approved',1],['user_id',$user->id],['view','public']])
        //     ->get(['id','song_id','audio_id','screenshot'])
        //     ->each->setAppends(['imagePath','isLike','viewCount'])
        //     ->makeHidden(['song_id','audio_id']);
        // }
        $user->postCount = count($user->videos);
        return $user;
    }
    
    // Report User
    public function report_user(Request $request) {
        $request->validate([
            'user_id' => 'bail|required',
            'report_id' => 'bail|required',
        ]);
        $user = AppUser::find($request->user_id);
        if($user->isReported)
            return response()->json(['msg' => 'Already Reported', 'success' => false], 200);
        
        $report = new AllReport();
        $report->report_user_id = Auth::guard('appUserApi')->user()->id;
        $report->user_id = $user->id;
        $report->reason_id = $request->report_id;
        $report->type = "User";
        $report->save();
        return response()->json(['msg' => 'User reported successfully', 'success' => true], 200);
    }

    // Notification
    public function notification() {

        if(count(Auth::guard('appUserApi')->user()->requested) > 0  ) 
        {
            $data['requeste_count'] = Auth::guard('appUserApi')->user()->requested->sortByDesc('pivot.id')->values()->count();
            $last_request = Auth::guard('appUserApi')->user()->requested->sortByDesc('pivot.id')->values()->first();
            $data['last_request'] = AppUser::find($last_request->id,['id','image'])->setAppends(['imagePath']);
        } else {
            $data['requeste_count'] = 0;
            $data['last_request'] = null;
        }

        $date = \Carbon\Carbon::today()->subDays(7);

        $data['current'] = Notification::with('user','video')
        ->where('friend_id',Auth::guard('appUserApi')->user()->id)
        ->where('created_at', '>=', $date)
        ->orderBy('id','desc')
        ->get()
        ->makeHidden(['updated_at']);
        foreach($data['current'] as $item) {
            $item->user->setAppends(['imagePath']);
            if($item->video)
                $item->video->setAppends(['imagePath'])->makeHidden(['song_id','audio_id']);
        }

        $data['last_seven'] = Notification::with('user','video')
        ->where('friend_id',Auth::guard('appUserApi')->user()->id)
        ->where('created_at', '<', $date)
        ->orderBy('id','desc')
        ->get()
        ->makeHidden(['updated_at']);
        foreach($data['last_seven'] as $item) {
            $item->user->setAppends(['imagePath']);
            if($item->video)
                $item->video->setAppends(['imagePath'])->makeHidden(['song_id','audio_id']);
        }

        return response()->json(['msg' => 'All notifications','data' => $data, 'success' => true], 200);
    }

    // my profile
    public function my_profile()
    {
        $user = Auth::guard('appUserApi')->user();
        $data['mainUser'] = AppUser::find($user->id,['id','name','user_id','image','bio','bdate','phone','email','gender'])
        ->setAppends(['imagePath','followersCount','followingCount']);

        $data['posts'] = Video::where([['user_id',$user->id],['is_approved',1]])->orderBy('id','desc')
        ->get(['id','song_id','audio_id','screenshot','video'])->makeHidden(['song_id','audio_id'])
        ->each->setAppends(['isLike','imagePath','viewCount']);

        $data['saved'] = Saved::with('video')->where('user_id',$user->id)->orderBy('id','desc')
        ->get(['id','user_id','video_id'])->makeHidden(['video_id']);
        foreach($data['saved'] as $item) {
            $item->video->makeHidden(['song_id','audio_id'])->setAppends(['imagePath','isLike','viewCount']);
            $item->video->user->setAppends(['imagePath'])->makeHidden(['device_token']);
        }

        $data['liked'] = Like::with('video')->where([['user_id',$user->id],['likeable_type','App\Models\Video']])->orderBy('id','desc')
        ->get(['id','likeable_type','user_id','likeable_id'])->makeHidden(['likeable_type','user_id','likeable_id']);
        foreach($data['liked'] as $item) {
            $item->video->makeHidden(['song_id','audio_id'])->setAppends(['imagePath','isLike','viewCount']);
            $item->video->user->setAppends(['imagePath'])->makeHidden(['device_token']);
        }

        return response()->json(['msg' => 'My profile','data' => $data, 'success' => true], 200);
    }

    public function my_profile_info()
    {
        $user = Auth::guard('appUserApi')->user()->makeHidden(['device_token','otp','created_at','updated_at','isReported','reportReasons']);
        return response()->json(['msg' => 'My profile','data' => $user, 'success' => true], 200);
    }

    // Edit Profile
    public function edit_profile(Request $request) {
        $request->validate([
            'name' => 'bail|required',
            'image' => 'bail|',
            'gender' => 'bail|',
            'bdate' => 'bail|',
            'bio' => 'bail|',
        ]);
        $user = AppUser::find(Auth::guard('appUserApi')->user()->id);
        if(isset($request->image))
        {
            if($user->image != "noimage.jpg")
            {
                if(\File::exists(public_path('/image/user/'. $user->image))){
                    \File::delete(public_path('/image/user/'. $user->image));
                }
            }
            $img = $request->image;
            $img = str_replace('data:image/png;base64,', '', $img);
            
            $img = str_replace(' ', '+', $img);
            $data1 = base64_decode($img);
            $name = "User_". uniqid() . ".png";
            $file = public_path('/image/user/') . $name;

            $success = file_put_contents($file, $data1);
            $user->image = $name;
        }
        $user->name = $request->name;
        $user->bio = $request->bio;
        $user->bdate = $request->bdate;
        $user->gender = $request->gender;
        $user->save();
        return response()->json(['msg' => 'Profile updated successfully', 'success' => true], 200);
    }

    // Followers / following
    public function own_followers()
    {
        $all_followers = Auth::guard('appUserApi')->user()->followers->sortByDesc('pivot.id')->each->setAppends(['imagePath'])->values()->all();
        $followers_arr = array();
        foreach($all_followers as $item) {
            $user = AppUser::find($item->id,['id','name','user_id','image'])->setAppends(['imagePath','followersCount','isFollowing']);
            array_push($followers_arr, $user);
        }
        $data['followers'] = $followers_arr;
        
        $all_followings = Auth::guard('appUserApi')->user()->followings->sortByDesc('pivot.id')->each->setAppends(['imagePath'])->values()->all();
        $followings_arr = array();
        foreach($all_followings as $item) {
            $user = AppUser::find($item->id,['id','name','user_id','image'])->setAppends(['imagePath','followersCount']);
            array_push($followings_arr, $user);
        }
        $data['followings'] = $followings_arr;
        return response()->json(['msg' => 'Followers & Followings','data' => $data, 'success' => true], 200);
    }

    // Follow requests
    public function follow_requests() {
        $all_request = Auth::guard('appUserApi')->user()->requested->sortByDesc('pivot.id')->each->setAppends(['imagePath'])->values()->all();
        $user_arr = array();
        foreach($all_request as $item) {
            $user = AppUser::find($item->id,['id','name','user_id','image'])->setAppends(['imagePath']);
            array_push($user_arr, $user);
        }
        $data['follow_requests'] = $user_arr;

        $users = AppUser::where([['status',1]])
        ->get(['id','name','user_id','image'])
        ->each->setAppends(['imagePath'])
        ->sortByDesc('followers_count');

        foreach($users as $key => $user){
            if(Auth::guard('appUserApi')->user()->id == $user->id) {
                unset($users[$key]);
            }
            $is_following = Auth::guard('appUserApi')->user()->isFollowing($user);
            if($is_following) {
                unset($users[$key]);
            }
        }
        $data['suggesions'] =  $users->values()->all();

        return response()->json(['msg' => 'Follow Request','data' => $data, 'success' => true], 200);
    }

    // Search followers $ following
    public function search_followers_old(Request $request)
    {
        $request->validate([
            'search' => 'bail|required',
            'type' => 'bail|required',
        ]);
        $query = $request->search;

        if($request->type == "Followers") {
            $users =  Auth::guard('appUserApi')->user()->followings()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('user_id', 'like', '%' . $query . '%')
            ->get();
        }
        else{
            $users =  Auth::guard('appUserApi')->user()->followers()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('user_id', 'like', '%' . $query . '%')
            ->get();
        }
        return response()->json(['msg' => 'Search users','data' => $users, 'success' => true], 200);
    }
    
    public function search_followers(Request $request)
    {
        $request->validate([
            'search' => 'bail|required',
            'type' => 'bail|required',
        ]);
        $query = $request->search;

        if($request->type == "Followers") {
            $users =  Auth::guard('appUserApi')->user()->followings()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('user_id', 'like', '%' . $query . '%')->get();
        }
        else{
            $users =  Auth::guard('appUserApi')->user()->followers()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('user_id', 'like', '%' . $query . '%')->get();
        }
        foreach($users as $user){
            $user->setAppends(['imagePath'])
            ->makeHidden(['email','code','phone','bdate','gender','bio','status','is_verify','device_token','platform','provider',
            'otp','follower_request','mention_not','like_not','comment_not','follow_not','request_not','not_interested','report',
            'lat','lang','created_at','updated_at','pivot']);
        }
        return response()->json(['msg' => 'Search users','data' => $users, 'success' => true], 200);
       
    }

    // Select songs
    public function select_song() {
        $songs = Song::where('status',1)->orderBy('id','desc')->get(['id','title','image','artist','movie','audio','duration']);
        $data['all'] = $songs;

        $data['popular'] = $songs->sortByDesc('songUsed')->where('songUsed',"!=", 0)
        ->each->setAppends(['imagePath','isFavorite'])->values()->all();

        $data['playlist'] = SongSection::where('status',1)->orderBy('order','asc')
        ->get(['id','title','image'])->each->setAppends(['imagePath']);

        $data['favorite'] = SongFavorite::with('song')->where('user_id',Auth::guard('appUserApi')->user()->id)->orderBy('id','asc')
        ->get(['id','song_id'])->makeHidden(['song_id']);
        foreach($data['favorite'] as $item) {
            $item->song->setAppends(['imagePath']);
        }
        
        return response()->json(['msg' => 'Select songs or playlist','data' => $data, 'success' => true], 200);
    }

    public function single_playlist($id) {
        $songs = Song::where('status',1)->get(['id','section_id']);
        $section_ids = array();
        foreach($songs as $song) {
            $section_id = json_decode($song->section_id);
            if(in_array($id, $section_id))
                array_push($section_ids, $song->id);
        }
        $songs = Song::whereIn('id',$section_ids)->get(['id','title','image','artist','movie'])->sortByDesc('songUsed')->makeHidden(['songUsed'])->values()->all();
      
        return response()->json(['msg' => 'Section vise songs','data' => $songs, 'success' => true], 200);
    }
    
    public function single_song($id) {
        $song = Song::find($id,['id','title','audio','image','artist','movie','duration']);
        $song_videos = Video::where([['song_id',$id],['view','public'],['is_approved',1]])
        ->get(['id','song_id','audio_id','screenshot'])
        ->each->setAppends(['imagePath','is_like','viewCount']);
        
        if(Auth::guard('appUserApi')->check()) {

            // Auth Followings -> videos
            $auth_followings =  Auth::guard('appUserApi')->user()->followings()->get();
            $vid_ids = array();
            foreach($auth_followings as $followings) {
                $videos = Video::where([['user_id',$followings->id],['song_id',$id],['view','followers'],['is_approved',1]])->get();
                foreach($videos as $vid){
                    array_push($vid_ids, $vid->id);
                }
            }

            // Remove Blocked users and Auth video
            $blocked = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->orWhere([['blocked_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->get();
            $block_ids = array();
            foreach($blocked as $block) {
                array_push($block_ids,$block->blocked_id);
                array_push($block_ids,$block->user_id);
            }

            $videos_auth = Video::whereIn('id',$vid_ids)
            ->whereNotIn('user_id',$block_ids)
            ->get(['id','song_id','audio_id','screenshot'])
            ->each->setAppends(['imagePath','is_like','viewCount']);
            
            $song_videos = $song_videos->merge($videos_auth);
        }
        
        $song->videos = $song_videos->sortByDesc('viewCount')->makeHidden(['song_id','audio_id'])->values()->all();

        return response()->json(['msg' => 'Single Song','data' => $song, 'success' => true], 200);
    }
    
    public function single_audio($id) {
        $audio = Audio::with('user','video')->find($id,['id','user_id','video_id','audio','duration'])->makeHidden(['userName']);
        $audio_videos = Video::where([['audio_id',$id],['view','public'],['is_approved',1]])
        ->get(['id','song_id','audio_id','screenshot'])
        ->each->setAppends(['imagePath','is_like','viewCount']);
        
        if(Auth::guard('appUserApi')->check()) {

            // Auth Followings -> videos
            $auth_followings =  Auth::guard('appUserApi')->user()->followings()->get();
            $vid_ids = array();
            foreach($auth_followings as $followings) {
                $videos = Video::where([['user_id',$followings->id],['audio_id',$id],['view','followers'],['is_approved',1]])->get();
                foreach($videos as $vid){
                    array_push($vid_ids, $vid->id);
                }
            }

            // Remove Blocked users and Auth video
            $blocked = Block::where([['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->orWhere([['blocked_id',Auth::guard('appUserApi')->user()->id],['type','User']])
            ->get();
            $block_ids = array();
            foreach($blocked as $block) {
                array_push($block_ids,$block->blocked_id);
                array_push($block_ids,$block->user_id);
            }

            $videos_auth = Video::whereIn('id',$vid_ids)
            ->whereNotIn('user_id',$block_ids)
            ->get(['id','song_id','audio_id','screenshot'])
            ->each->setAppends(['imagePath','is_like','viewCount']);
            
            $audio_videos = $audio_videos->merge($videos_auth);
        }
        
        $audio->user->setAppends(['imagePath']);
        $audio->video->setAppends(['imagePath'])->makeHidden(['song_id','audio_id']);
        $audio->all_videos = $audio_videos->sortByDesc('viewCount')->makeHidden(['song_id','audio_id'])->values()->all();

        return response()->json(['msg' => 'Single Audio','data' => $audio, 'success' => true], 200);
    }

    public function add_favorite($id) {
        $hasFavorite = SongFavorite::where([['user_id',Auth::guard('appUserApi')->user()->id],['song_id',$id]])->first();
        if(isset($hasFavorite)){
            $fav = SongFavorite::find($hasFavorite->id)->delete();
            return response()->json(['msg' => 'Remove from favorites','data' => 0, 'success' => true], 200);
        }
        else
        {
            $fav = new SongFavorite();
            $fav->user_id = Auth::guard('appUserApi')->user()->id;
            $fav->song_id = $id;
            $fav->save();
            return response()->json(['msg' => 'Added to favorites', 'data' => 1,'success' => true], 200);
        }
    }

    // Search
    public function search_song($query) {

        $songs = Song::where([['title', 'like', '%' . $query . '%'],['status',1]])
        ->orWhere([['artist', 'like', '%' . $query . '%'],['status',1]])
        ->orWhere([['movie', 'like', '%' . $query . '%'],['status',1]])
        ->orWhere([['lang', 'like', '%' . $query . '%'],['status',1]])
        ->get(['id','title','image','artist','movie','status','lang','duration'])
        ->each->setAppends(['imagePath'])
        ->makeHidden(['status','lang'])
        ->sortByDesc('songUsed')->values()->all();

        return response()->json(['msg' => 'Songs', 'data' => $songs, 'success' => true], 200);
    }
    
    // Search creators default (Copy) 
    public function follow_and_invite(){
        $users = AppUser::where('status',1)
        ->get(['id','name','user_id','image'])
        ->sortByDesc('followers_count');

        if(Auth::guard('appUserApi')->check()){
            foreach($users as $key => $user){
                if(Auth::guard('appUserApi')->user()->id == $user->id){
                    unset($users[$key]);
                }
                $is_following = Auth::guard('appUserApi')->user()->isFollowing($user);
                if($is_following) {
                    unset($users[$key]);
                }
            }
        }
        $users->each->setAppends(['imagePath','followersCount']);
        $users =  $users->values()->all();
        return response()->json(['msg' => 'Follow & Invite Friends', 'data' => $users, 'success' => true], 200);
    }

    public function notification_settings(Request $request) {
        $user = Auth::guard('appUserApi')->user();
        
        if($request->mention_not == 1){ $user->mention_not = 1; }
        else { $user->mention_not = 0; }

        if($request->like_not == 1){ $user->like_not = 1; }
        else { $user->like_not = 0; }

        if($request->comment_not == 1){ $user->comment_not = 1; }
        else { $user->comment_not = 0; }

        if($request->follow_not == 1){ $user->follow_not = 1; }
        else { $user->follow_not = 0; }

        if($request->request_not == 1){ $user->request_not = 1; }
        else { $user->request_not = 0; }

        $user->save();
        return response()->json(['msg' => 'Notification Setting saved successfully', 'success' => true], 200);

    }

    public function privacy_settings(Request $request) {

        $user = Auth::guard('appUserApi')->user();

        if($request->follower_request == 1){ $user->follower_request = 1; }
        else { $user->follower_request = 0; }
        
        $user->save();
        return response()->json(['msg' => 'Privacy Settings saved successfully', 'success' => true], 200);
    }

    public function language() {
        $languages = Language::where('status',1)->orderBy('order','ASC')->get(['id','name'])->each->setAppends([]);
        return response()->json(['msg' => 'Languages', 'data' => $languages ,'success' => true], 200);
    }

    public function send_otp($user)
    {
        $otp = rand(1111,9999);
        $user->otp = $otp;
        $user->save();

        $mail_content = Template::where('title','User Verification')->first()->mail_content;
        $msg_content = Template::where('title','User Verification')->first()->msg_content;
        $detail['UserName'] = $user->name;
        $detail['UserId'] = $user->user_id;
        $detail['OTP'] = $otp;
        $detail['AdminName'] = Setting::first()->app_name;

        $verify_email = Setting::first()->verify_email;
        $verify_sms = Setting::first()->verify_sms;
        if($verify_email){
            try{
                Mail::to($user->email)->send(new OTP($mail_content,$detail));
            }
            catch(\Throwable $th){}
        }
        if($verify_sms){
            $sid = Setting::first()->twilio_acc_id;
            $token = Setting::first()->twilio_auth_token;
            $data = ["{UserName}","{UserId}", "{OTP}","{AdminName}"];
            $message1 = str_replace($data, $detail, $msg_content);
            try{
                $client = new Client($sid, $token);
                
                $client->messages->create(
                    $user->code.$user->phone,
                    array(
                    'from' => Setting::first()->twilio_phone_no,
                    'body' => $message1
                    )
                );
            }
            catch(\Throwable $th){}
        }
        return true;
    }
}
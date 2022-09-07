<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use Auth;

class Comment extends Model
{
    use HasFactory, Likeable;
    
    protected $table = 'comments';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['likesCount','isLike','isReported','report','reportReasons','canDelete'];

    public function user()
    {
        return $this->hasOne(AppUser::class,'id','user_id')->select(['id','user_id','name','image','device_token','like_not']);
    }
    
    public function video()
    {
        return $this->hasOne(Video::class,'id','video_id')->select(['id','user_id','song_id','audio_id']);
    }

    public function getIsLikeAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            if(Auth::guard('appUserApi')->user()->hasLiked($this))
                return 1;
        }
        return 0;
    }
    
    public function getLikesCountAttribute()
    {
        $n =  $this->likes()->count();

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
        return $n_format . $suffix;
    }
    
    public function getIsReportedAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $report = AllReport::where([['report_user_id',Auth::guard('appUserApi')->user()->id],['comment_id',$this->id]])->first();
            if($report)
                return 1;
        }
        return 0;
    }
    
    public function getReportAttribute()
    {
        $report = AllReport::where([['type','Comment'],['comment_id',$this->id]])->count();
        return $report;
    }

    public function getReportReasonsAttribute()
    {
        $reports = AllReport::where([['type','Comment'],['comment_id',$this->id]])->get();
        $names = array();
        foreach($reports as $report) {
            $reason = Report::find($report->reason_id);
            array_push($names,$reason->reason);
        }
        return array_count_values($names);
    }

    public function getCanDeleteAttribute()
    {
        if($this->user_id == Auth::guard('appUserApi')->user()->id || $this->video->user->id == Auth::guard('appUserApi')->user()->id){
            return 1;
        }
        return 0;
    }

}

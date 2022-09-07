<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelLike\Traits\Likeable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Auth;
use DB;

class Video extends Model implements Viewable
{
    use HasFactory, Likeable, InteractsWithViews;
    
    protected $table = 'video';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','originalAudio','commentCount','likeCount','viewCount','isLike',
    'isSaved','isReported','report','reportReasons','isYou'];
    
    public function user()
    {
        return $this->hasOne(AppUser::class,'id','user_id')->select(['id','user_id','name','image','device_token','follower_request']);
    }
     
    public function getImagePathAttribute()
    {
        return url('image/video') . '/';
    }
    
    public function getoriginalAudioAttribute()
    {
        if($this->song_id != null) {
            $song = Song::find($this->song_id);
            if($song->artist != null)
                return $song->title ." - ". $song->artist." ";
            
            if($song->movie != null)
                return $song->title ." - ". $song->movie." ";

            return $song->title;
        }
        elseif ($this->audio_id != null) {
            $audio = Audio::find($this->audio_id);
            return $audio->userName." ";
        } else {
            return null;
        }
    }
    
    public function getcommentCountAttribute()
    {
        $comment_count = Comment::where([['video_id',$this->id]])->count();
        $n =  $comment_count;

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
    
    public function getlikeCountAttribute()
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

    public function getviewCountAttribute()
    {
        $n = views($this)->count();

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

    
    public function getIsYouAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            if(Auth::guard('appUserApi')->user()->id == $this->user_id)
                return true;
        }
        return false;
    }
    
    public function getIsLikeAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            if(Auth::guard('appUserApi')->user()->hasLiked($this))
                return true;
        }
        return false;
    }
    
    public function getIsSavedAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $save = Saved::where([['user_id',Auth::guard('appUserApi')->user()->id],['video_id',$this->id]])->first();
            if($save)
                return 1;
        }
        return 0;
    }
    
    public function getIsReportedAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $report = AllReport::where([['report_user_id',Auth::guard('appUserApi')->user()->id],['video_id',$this->id]])->first();
            if($report)
                return 1;
        }
        return 0;
    }
    
    public function getReportAttribute()
    {
        $report = AllReport::where([['type','Video'],['video_id',$this->id]])->count();
        return $report;
    }

    public function getReportReasonsAttribute()
    {
        $reports = AllReport::where([['type','Video'],['video_id',$this->id]])->get();
        $names = array();
        foreach($reports as $report) {
            $reason = Report::find($report->reason_id);
            array_push($names,$reason->reason);
        }
        return array_count_values($names);
    }
}

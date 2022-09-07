<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Overtrue\LaravelFollow\Followable;
use Overtrue\LaravelLike\Traits\Liker;

use Auth;

class AppUser extends Authenticatable{
    
    use HasFactory, Notifiable, HasApiTokens, Followable, Liker;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'app_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_id',
        'is_verify',
        'provider',
        'provider_token',
        'device_token',
        'platform',
        'phone',
        'code',
        'not_interested'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'provider_token'
    ];
    protected $dates = [
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['imagePath','isFollowing','isRequested','followersCount','followingCount','isCommentBlock','isBlock','isReported','report','reportReasons'];
    
    public function getImagePathAttribute()
    {
        return url('image/user') . '/';
    }
    
    public function getIsFollowingAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            if(Auth::guard('appUserApi')->user()->isFollowing($this))
                return 1;
        }
        return 0;
    }

    public function getIsRequestedAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $found = User_Follower::where([['following_id',$this->id],['follower_id',Auth::guard('appUserApi')->user()->id],['accepted_at',null]])->first();
            if($found)
                return 1;
        }
        return 0;
    }
     
    public function getFollowersCountAttribute()
    {
        $n = $this->followers()->count();
        
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

    public function getFollowingCountAttribute()
    {
        $n =  $this->followings()->count();
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
    
    public function getIsCommentBlockAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            // $is = Block::where([['blocked_id',Auth::guard('appUserApi')->user()->id],['user_id',$this->id],['type','Comment']])->first();
            $is = Block::where([['blocked_id',$this->id],['user_id',Auth::guard('appUserApi')->user()->id],['type','Comment']])->first();
            if(isset($is))
                return 1;
        }
        return 0;
    }
    
    public function getIsBlockAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            // $is = Block::where([['blocked_id',Auth::guard('appUserApi')->user()->id],['user_id',$this->id],['type','User']])->first();
            $is = Block::where([['blocked_id',$this->id],['user_id',Auth::guard('appUserApi')->user()->id],['type','User']])->first();
            if(isset($is))
                return 1;
        }
        return 0;
    }

    public function needsToApproveFollowRequests()
    {
        return $this->follower_request;
    }
     
    public function getIsReportedAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $report = AllReport::where([['report_user_id',Auth::guard('appUserApi')->user()->id],['user_id',$this->id]])->first();
            if($report)
                return 1;
        }
        return 0;
    }
    
    public function getReportAttribute()
    {
        $report = AllReport::where([['type','User'],['user_id',$this->id]])->count();
        return $report;
    }

    public function getReportReasonsAttribute()
    {
        $reports = AllReport::where([['type','User'],['user_id',$this->id]])->get();
        $names = array();
        foreach($reports as $report) {
            $reason = Report::find($report->reason_id);
            array_push($names,$reason->reason);
        }
        return array_count_values($names);
    }
    
    public function video()
    {
        return $this->hasOne(Video::class,'user_id','id');
    }
}

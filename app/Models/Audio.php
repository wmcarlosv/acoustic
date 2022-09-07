<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;
      
    protected $table = 'audio';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','userName','audioUsed'];
    
    public function getImagePathAttribute()
    {
        return url('image/user_audio') . '/';
    }
    public function getuserNameAttribute()
    {
        $user = AppUser::find($this->user_id);
        return $user->name;
    }
    
    public function user()
    {
        return $this->hasOne(AppUser::class,'id','user_id')->select(['id','user_id','name','image']);
    }
    public function video()
    {
        return $this->hasOne(Video::class,'id','video_id')->select(['id','song_id','audio_id','screenshot']);
    }
      
    public function getAudioUsedAttribute()
    {
        $audio_used = Video::where('audio_id',$this->id)->count();
        return $audio_used;
    }
   
}

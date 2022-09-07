<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
        
    protected $table = 'notification';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['time'];
   
    public function user()
    {
        return $this->hasOne(AppUser::class,'id','user_id')->select(['id','user_id','name','image']);
    }
    
    public function video()
    {
        return $this->hasOne(Video::class,'id','video_id')->select(['id','screenshot','song_id','audio_id']);
    }

    public function getTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

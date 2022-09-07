<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saved extends Model
{
    use HasFactory;
       
    protected $table = 'saved_video';
    public $primaryKey = 'id';
    public $timestamps = true;
    
    public function video()
    {
        return $this->hasOne(Video::class,'id','video_id')->select(['id','song_id','user_id','audio_id','video','screenshot']);
    }
}

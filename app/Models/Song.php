<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Song extends Model
{
    use HasFactory; 

    protected $table = 'song';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','songUsed','isFavorite'];
    
    public function getImagePathAttribute()
    {
        return url('image/song') . '/';
    }
    
    public function getSongUsedAttribute()
    {
        $song_used = Video::where('song_id',$this->id)->count();
        return $song_used;
    }

    public function getIsFavoriteAttribute()
    {
        if(Auth::guard('appUserApi')->check()){
            $isFavorite = SongFavorite::where([['user_id',Auth::guard('appUserApi')->user()->id],['song_id',$this->id]])->first();
            if($isFavorite)
                return 1;
        }
        return 0;
    }
}

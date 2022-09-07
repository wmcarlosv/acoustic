<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongFavorite extends Model
{
    use HasFactory;
    
    protected $table = 'song_favorite';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function song()
    {
        return $this->hasOne(Song::class,'id','song_id')->select(['id','title','image','artist','movie','audio']);
    }
}

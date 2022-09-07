<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
        
    protected $table = 'language';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['songCount','videoCount'];
    
    public function getSongCountAttribute()
    {
        $songs = Song::where([['lang',$this->name],['status',1]])->count();
        return $songs;
    }
    public function getVideoCountAttribute()
    {
        $vid = Video::where([['language',$this->name],['is_approved',1]])->count();
        return $vid;
    }
}

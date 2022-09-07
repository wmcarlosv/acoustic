<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SongSection extends Model
{
    use HasFactory;
     
    protected $table = 'song_section';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','songCount'];
    
    public function getImagePathAttribute()
    {
        return url('image/song_section') . '/';
    } 
    public function getSongCountAttribute()
    {
        $songs = Song::where('status',1)->get(['id','section_id']);
        $section_ids = array();
        foreach($songs as $song) {
            $section_id = json_decode($song->section_id);
            if(in_array($this->id, $section_id))
                array_push($section_ids, $song->id);
        }
        return count($section_ids);
    }
}

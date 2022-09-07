<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;
    
    protected $table = 'challenge';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath','challengeUsed'];
    
    public function getImagePathAttribute()
    {
        return url('image/challenge') . '/';
    }
       
    public function getChallengeUsedAttribute()
    {
        $vids = Video::where([['is_approved',1],['view','!=','private']])->get();
        $vid_ids = array();
        foreach($vids as $vid){
            if($vid->hashtags != NULL){
                $tags = json_decode($vid->hashtags);
                foreach($tags as $tag) {
                    if($this->title == $tag) {
                        if(!in_array($vid->id,$vid_ids))
                            array_push($vid_ids,$vid->id);
                    }
                }
            }
        }
        return count($vid_ids);
    }
}

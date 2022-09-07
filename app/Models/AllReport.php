<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllReport extends Model
{
    use HasFactory;
    
    protected $table = 'all_reports';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['reportComment','reportUser','reportVideo'];
    
    public function getReportCommentAttribute()
    {
        $com = Comment::find($this->comment_id);
        return $com;
    } 
    public function getReportUserAttribute()
    {
        $user = AppUser::find($this->user_id);
        return $user;
    }
    public function getReportVideoAttribute()
    {
        $vid = Video::find($this->video_id);
        return $vid;
    }
}

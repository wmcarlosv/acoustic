<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;
    protected $table = 'problem';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['name','userName','userImage','createTime'];
    
    public function getNameAttribute()
    {
        if($this->user_id != null){
            $user = AppUser::find($this->user_id);
            return $user->user_id;
        }
        return '';
    }
    public function getUserNameAttribute()
    {
        if($this->user_id != null){
            $user = AppUser::find($this->user_id);
            return $user->name;
        }
        return $this->email;
    }
    public function getUserImageAttribute()
    {
        if($this->user_id != null){
            $user = AppUser::find($this->user_id);
            return $user->image;
        }
        return 'noimage.jpg';
    }
    public function getCreateTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Follower extends Model
{
    use HasFactory;
      
    protected $table = 'user_follower';
    public $primaryKey = 'id';
    public $timestamps = true;
}

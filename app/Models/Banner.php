<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    
    protected $table = 'banner';
    public $primaryKey = 'id';
    public $timestamps = true;
    protected $appends = ['imagePath'];
    
    public function getImagePathAttribute()
    {
        return url('image/banner') . '/';
    }
}

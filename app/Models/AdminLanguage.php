<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLanguage extends Model
{
    use HasFactory;
    
    protected $table = 'admin_language';
    public $primaryKey = 'id';
    public $timestamps = true;
}

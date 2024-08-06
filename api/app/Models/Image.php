<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;
     protected $table = 'images';
     protected $fillable = [
         'title', 'path', 'user_id',
     ];
}


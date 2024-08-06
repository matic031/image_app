<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharedImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_id',
        'shared_with_user_id',
    ];
}

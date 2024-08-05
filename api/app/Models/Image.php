<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;
    // protected $table = 'images';
    // protected $fillable = [
    //     'title', 'path', 'user_id', 'shared_url',
    // ];


    protected $fillable = [
        'title', 'path',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

//     protected static function boot()
// {
//     parent::boot();

//     static::creating(function ($image) {
//         $image->shared_url = Str::uuid();
//     });
// }
}


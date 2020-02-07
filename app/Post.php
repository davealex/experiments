<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['file_path'];

    public static function newPost($post)
    {
        return static::create([
            'file_path' => $post
        ]);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title', 'code'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function registerLearners($courses, $users)
    {
        static::find($courses)->each(function ($course) use ($users) {
            $course->users()->syncWithoutDetaching($users);
        });
    }
}

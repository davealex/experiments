<?php

namespace App\Services;

use Illuminate\Support\Str;

class NewPathGenerator
{

    public static function  path($filePath)
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $newFilename = Str::random(40) . '.' . $extension;
        $newPath = 'uploads/' . $newFilename;

        return $newPath;
    }
}

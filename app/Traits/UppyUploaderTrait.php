<?php

namespace App\Traits;

use App\Services\NewPathGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait UppyUploaderTrait
{

    public function upload(Request $request)
    {

        return response([
            'path' => $this->generateTempFilePath($request)
        ], 200);

    }

    public function generateTempFilePath(Request $request)
    {

        return $request->file('file')->store('/uploads/temp', 'public');

    }

    public function moveFileToPath($tempPath)
    {

        $newPath = NewPathGenerator::path($tempPath);

        Storage::disk('public')->move($tempPath, $newPath);

        return $newPath;

    }
}

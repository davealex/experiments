<?php

namespace App\Traits;

use App\Services\FileUploadProcessor;
use Illuminate\Http\Request;

trait UppyUploaderTrait
{
    public function upload(Request $request, FileUploadProcessor $fileUploadProcessor)
    {
        return response([
            'path' => $fileUploadProcessor->generateTempFileStoragePath($request)
        ], 200);
    }
}

<?php

namespace App\Traits;

use App\Services\FileUploadProcessor;
use Illuminate\Http\Request;

trait UppyUploaderTrait
{
    protected $fileUploadProcessor;

    public function __construct(FileUploadProcessor $fileUploadProcessor)
    {
        $this->fileUploadProcessor = $fileUploadProcessor;
    }

    public function upload(Request $request)
    {
        return response([
            'path' => $this->fileUploadProcessor->generateTempFileStoragePath($request)
        ], 200);
    }

    public function getMovedFilePath($file)
    {
        return $this->fileUploadProcessor->moveFileToRealStoragePath($file);
    }
}

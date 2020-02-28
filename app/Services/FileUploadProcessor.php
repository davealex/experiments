<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class FileUploadProcessor
 * @package App\Services
 */
class FileUploadProcessor
{
    /**
     * @param $filePath
     * @return mixed
     */
    protected function getFileExtension($filePath)
    {
        return pathinfo($filePath, PATHINFO_EXTENSION);
    }

    /**
     * @param $extension
     * @return string
     */
    protected function generateFileName($extension)
    {
        return Str::random(40) . '.' . $extension;
    }

    /**
     * @param $filePath
     * @return string
     */
    public function generateRealFileStoragePath($filePath)
    {
        $extension = $this->getFileExtension($filePath);
        $newFilename = $this->generateFileName($extension);

        return 'uploads/' . $newFilename;
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function generateTempFileStoragePath(Request $request)
    {
        return $request->file('file')->store('/uploads/temp', 'public');
    }

    /**
     * @param $tempPath
     * @return string
     */
    public function moveFileToRealStoragePath($tempPath)
    {
        $newPath = $this->generateRealFileStoragePath($tempPath);

        Storage::disk('public')->move($tempPath, $newPath);

        return $newPath;
    }
}

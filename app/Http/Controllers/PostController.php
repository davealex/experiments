<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\FileUploadProcessor;
use App\Traits\UppyUploaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use UppyUploaderTrait;

    public function store(Request $request, FileUploadProcessor $fileUploadProcessor)
    {
        if ($request->file) {
            $post = Post::publishNewPost($fileUploadProcessor->moveFileToRealStoragePath($request->file));

            return response([
                'path' => Storage::url($post->file_path)
            ], 201);
        }

        return response([], 400);
    }
}

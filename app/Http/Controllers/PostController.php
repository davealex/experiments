<?php

namespace App\Http\Controllers;

use App\Post;
use App\Traits\UppyUploaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use UppyUploaderTrait;

    public function store(Request $request)
    {
        if ($request->file) {

            $post = Post::newPost($this->moveFileToPath($request->file));

            return response([
                'path' => Storage::url($post->file_path)
            ], 201);

        }
        return response([], 400);
    }
}

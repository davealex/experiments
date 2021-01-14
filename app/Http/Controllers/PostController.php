<?php

namespace App\Http\Controllers;

use App\Post;
use App\Services\NewPathGenerator;
use App\Traits\UppyUploaderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    use UppyUploaderTrait;

    public function store(Request $request)
    {
        if ($request->files) {
            $paths = [];

//            return response([
//                'paths' => json_decode($request['files'], true)
//            ], 201);

            foreach (json_decode($request['files']) as $file) {
                $post = Post::newPost($this->moveFileToPath($file));
                $paths[] = Storage::url($post->file_path);
            }
//
            return response([
                'paths' => $paths
            ], 201);

        }
        return response([], 400);
    }

//    public function store(NewPathGenerator $newPathGenerator)
//    {
//        $post = Post::newPost($newPathGenerator->moveFileToPath($request->file));
//
//        return response([
//            'path' => Storage::url($post->file_path)
//        ], 201);
//    }
}

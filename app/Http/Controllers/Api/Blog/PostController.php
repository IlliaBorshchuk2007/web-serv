<?php

namespace App\Http\Controllers\Api\Blog;

use Illuminate\Http\Request;
use App\Models\BlogPost;

class PostController extends BaseController
{
    public function index() {
        $posts = BlogPost::with(['user', 'category'])->get();
        return response()->json($posts);
    }

    public function show($id) {
        $post = BlogPost::with(['user', 'category'])->findOrFail($id);
        return response()->json($post);
    }

    public function store(Request $request) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Request $request)
    {
    
        $data = $request->all();
        Post::create([
            'title' => $data['title'],
            'body' => $data['body'],
            'user_id' => auth()->user()->id
        ]);
    }
    
    public function like(Request $request)
    {
        //if previously reacted, overwrite
    }
    
    public function dislike(Request $request)
    {
        //if previously reacted, overwrite
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        //todo check to sequential comments
        Comment::create([
            'post_id' => $data['post_id'],
            'comment' => $data['comment'],
            'user_id' => auth()->user()->id
        ]);
    }
}

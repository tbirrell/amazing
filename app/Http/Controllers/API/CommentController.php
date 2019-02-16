<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        
        if ($this->can_comment($data['post_id'])) {
            Comment::create([
                'post_id' => $data['post_id'],
                'comment' => $data['comment'],
                'user_id' => auth()->user()->id
            ]);
            
            return response()->json(['success' => 'Comment posted']);
        } else {
            return response()->json(['error' => 'Consecutive comments not allowed']);
        }
    }
    
    protected function can_comment($post_id)
    {
        //get last comment for post
        $last_comment = Comment::where('post_id', $post_id)
               ->orderBy('created_at', 'desc')
               ->first();
        
        //check to see if current user posted it.
        if ($last_comment->user_id === auth()->user()->id) {
            return false;
        }
        
        return true;
    }
}

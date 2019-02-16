<?php

namespace App\Http\Controllers\API;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $cant_comment_because;
    
    public function create(Request $request)
    {
        $data = $request->all();
        
        if ($this->can_comment($data['repliable_type'], $data['repliable_id'])) {
            Comment::create([
                'repliable_id' => $data['repliable_id'],
                'repliable_type' => $data['repliable_type'],
                'comment' => $data['comment'],
                'user_id' => auth()->user()->id
            ]);
            
            return response()->json(['success' => 'Comment posted']);
        } else {
            return response()->json(['error' => $this->cant_comment_because]);
        }
    }
    
    protected function can_comment($replying_to, $id)
    {
        //if a reply, we have a special check
        if ($replying_to === 'comment') {
            //get parent
            $parent = Comment::find($id);
        
            //check to see if current user is the author of parent
            if ($parent->user_id === auth()->user()->id) {
                $this->cant_comment_because = 'Replying to own comment not allowed';
                return false;
            }
        
        }
        
        //get last comment for post
        $last_comment = Comment::where('repliable_type', $replying_to)
                               ->where('repliable_id', $id)
                               ->orderBy('created_at', 'desc')
                               ->first();
        
        //if there are not other comments
        if ($last_comment === null) {
            return true;
        }
        
        //check to see if current user posted it.
        if ($last_comment->user_id !== auth()->user()->id) {
            return true;
        }

        $this->cant_comment_because = 'Consecutive comments not allowed';
        return false;
    }
}

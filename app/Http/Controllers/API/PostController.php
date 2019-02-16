<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use App\Reaction;
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
    
        return response()->json(['success' => 'Post created']);
    }
    
    public function react(Request $request)
    {
        $data = $request->all();
        //we are going to assume that if you don't like it, you dislike it
        $like = $this->toBool($data['like']) ? 1 : 0;
        Reaction::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'reactionable_type' => $data['reactionable_type'],
                'reactionable_id' => $data['reactionable_id']
            ],
            ['reaction' => $like]
        );
        
        return response()->json(['success' => ucfirst($data['reactionable_type']).' '.($like?'liked':'disliked')]);
    }
    
    protected function toBool($var) {
        if (!is_string($var)) return (bool) $var;
        switch (strtolower($var)) {
            case '1':
            case 'true':
            case 'on':
            case 'yes':
            case 'y':
                return true;
            default:
                return false;
        }
    }
}


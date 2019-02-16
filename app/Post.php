<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];
    
    //=== RELATIONSHIPS ===//
    public function reaction()
    {
        return $this->morphOne(Reaction::class, 'reactionable');
    }
    
    public function comments()
    {
        return $this->morphMany(Comment::class, 'repliable');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

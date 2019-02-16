<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //=== RELATIONSHIPS ===//
    public function reaction()
    {
        return $this->morphOne(Reaction::class, 'reactionable');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];
    
    //=== RELATIONSHIPS ===//
    public function reaction()
    {
        return $this->morphOne(Reaction::class, 'reactionable');
    }
    
    public function repliable()
    {
        return $this->morphTo();
    }
    
    public function replies()
    {
        return $this->morphMany(self::class, 'repliable');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

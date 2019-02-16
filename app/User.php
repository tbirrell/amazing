<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    //=== RELATIONSHIPS ===//
    public function posts()
    {
        $this->hasMany(Post::class);
    }
    
    public function comments()
    {
        $this->hasMany(Comment::class);
    }
    
    public function reactions()
    {
        $this->hasMany(Reaction::class);
    }
    
    //=== SCOPES ===//
    public function scopeLikes($query)
    {
        $query->whereHas('reactions', function ($likes) {
            $likes->where('reaction', 1);
        })->get();
    }
    
    public function scopeDislikes($query)
    {
        $query->whereHas('reactions', function ($dislikes) {
            $dislikes->where('reaction', 0);
        })->get();
    }
}

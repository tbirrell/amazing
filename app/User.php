<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $guarded = ['id'];
    
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
    
    //=== METHODS ===//
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
}

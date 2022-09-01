<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];  
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function likers()
    {
        return $this->belongsToMany(User::class,'likes');
    }

    public function getLatestlikersAttribute()
    {
        return $this->belongsToMany(User::class,'likes')
        ->withPivot('user_id','post_id') 
        ->withTimestamps()
        ->orderBy('pivot_created_at','desc')
        ->take(5)
        ->get();
    }

 
}

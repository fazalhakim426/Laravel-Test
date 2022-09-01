<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{ 
    
    public function like_clicked(Post $post)
    {  
         $liked = Like::where('user_id', Auth::id())->where('post_id',$post->id)->first(); 
         if($liked){
            $liked->delete();
            return response()->json([
                'like' => false,
                'message' => 'Post unliked successfully.',
            ]); 
         }
         else{
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id
            ]);
            return response()->json([
                'like' => true,
                'message' => 'Post liked successfully.',
            ]);
         }
    }
}

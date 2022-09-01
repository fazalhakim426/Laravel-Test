<?php 
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;  
use Illuminate\Support\Facades\Route;

Route::get('/post',[  PostController::class,'index']);
Route::post('/login',[LoginController::class,'login']);

Route::apiResource('user',  UserController::class)->only(['index', 'store']);
 
 Route::group([
        'middleware' => ['auth:sanctum'], 
        'prefix' => 'auth' 
      ], function ($router) { 
      
        Route::get('like-clicked/{post}',[LikeController::class,'like_clicked']);
        Route::apiResource('post',PostController::class)->only(['destroy','store']);
        Route::get('post/{post}/likers',[PostController::class,'likers']);

});
 

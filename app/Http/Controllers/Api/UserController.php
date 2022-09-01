<?php

namespace App\Http\Controllers\Api;
 
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
class UserController extends Controller
{
    
    public function index()
    {

        return response()->json(['user'=> UserResource::collection(User::all())]); 
    }

    public function store(UserRequest $userRequest)
    {
      $user =   User::create($userRequest->all());  

         return response()->json([
            'message' => 'User created successfully!',
            'user' => new UserResource($user)
        ]);
        
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Events\PostCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\Post;

use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Auth;  

class PostController extends Controller
{

    public function index()
    { 
        $options = json_decode(request()->options);
        $itemPerPage = $options->itemsPerPage ?? 5;
        $page = $options->page ?? 1;
        $sortBy = $options->sortBy ?? 'created_at';
        $sortDesc = $options->sortDesc ? 'DESC' : 'ASC';
        $major_query = Post::with('user'); 
        $count = $major_query->count();
        $posts =  $major_query->when(request()->options, function ($query) use ($itemPerPage, $page) {
            $query->offset($itemPerPage * ($page - 1))
                ->take($itemPerPage);
        })->orderBy($sortBy, $sortDesc)
            ->get();

        return response()->json([
            'totol_post' => $count,
            'posts' => PostResource::collection($posts)
        ]);
    }

    public function store(PostRequest $postRequest)
    {

        $image_name = time() . $postRequest->file('image')->getClientOriginalName();
        $image_path = 'images/' . Auth::id();
        $postRequest->file('image')->storeAs('public/' . $image_path, $image_name);

        $post =   Post::create([
            'image' => $image_path . '/' . $image_name,
            'description' => $postRequest->description,
            'user_id' => Auth::id(),
            'uuid'=>Str::uuid()
            
        ]);

        event(new PostCreatedEvent($post));

        return response()->json(
            [
                'message' => 'Post created successfully',
                'post' => new PostResource($post)
            ]
        );
    }

    public function likers(Post $post)
    {
        return response()->json([
            'total_likers' => $post->likers()->count(),
            'likers' => UserResource::collection($post->likers),


        ]);
    }


    public function destroy(Post $post)
    {
        if ($post->user_id != Auth::id())
            return response()->json([
                'message' => 'Post not found.',
                'id' => ['Invalid post id.']
            ], 422);
        if (file_exists(public_path('storage/' . $post->image))) {
            unlink(public_path('storage/' . $post->image));
        }
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully.']);
    }
}

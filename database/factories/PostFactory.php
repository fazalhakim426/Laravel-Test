<?php

namespace Database\Factories;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory; 
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            // 'image' => fake()->imageUrl(100, 100, 'cats'),
            'image' => 'images/default.png',
            'description' => fake()->paragraph(),  
            'created_at' => now()->subDay(16), 
            'updated_at' => now(), 
            'uuid'=> Str::uuid()
        ];
    }
    public function configure(){
        return $this->afterCreating(function (Post $post){ 
           $users =  User::take(6)->get();  
            foreach($users as $user){  
              Like::create(
                [
                  'post_id' => $post->id,
                  'user_id' => $user->id,
                  'created_at' => now(),
                  'updated_at' => now(), 
                ]
                );
             }
              
        });
    }
}

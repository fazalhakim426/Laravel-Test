<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Illuminate\Support\Str;


class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
 
     
     public function test_unauthorized_user()
     {
        $response = $this->postJson('/api/auth/post'); 
        $response->assertStatus(401);  
             
     }

     //store.1
     //422 UserController::store
     //api Route::post('/api/auth/post')
     public function test_store_methode_required_fields()
     {

        $user = User::factory()->hasPosts(3)->create(); 


         $response = $this->withHeaders([
             'Authorization' => 'Bearer ' . $user->createToken('token')->plainTextToken
         ])->postJson('/api/auth/post');
         
 
         $response->assertStatus(422);
         $response->assertJson(fn(AssertableJson $json) =>
         $json->has('errors')->has('message'));
     }  
     
     //store.2
     //422 UserController::store
     //api Route::post('/api/auth/post')
     public function test_delete_post_successfully()
     { 
       $user = User::factory()->hasPosts(3)->create();  
         $response = $this->withHeaders([
             'Authorization' => 'Bearer ' . $user->createToken('toke')->plainTextToken
         ])->deleteJson('/api/auth/post/'.$user->posts()->first()->uuid);
          
         $response->assertStatus(200);
         $response->assertJson(fn(AssertableJson $json) =>
         $json->has('message'));
     }

}

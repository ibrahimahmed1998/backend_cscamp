<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Home\HRP;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\SearchController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//signup, login and logout
Route::post('/signup', [Authentication::class, 'signup']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/logout', [Authentication::class, 'logout']);

//------------------------------------
//post section
Route::get('/posts', [PostController::class, 'index']);
//input: title, body: the title has to be unique.
Route::post('/posts', [PostController::class, 'store']);

Route::get('/posts/{title}', [PostController::class, 'show']);
Route::post('/posts/{title}/edit', [PostController::class, 'update']);
Route::delete('/posts/{title}', [PostController::class, 'destroy']);

//add comment to a specific post
//inputs: comment, and a title in the url path.
Route::post("/posts/{title}/addComment",[CommentController::class, 'addComment']);

//to vote for some post, replace postTitle with the title of the post
//and you have to be logged in.
Route::post('posts/{postTitle}/vote',[VoteController::class,'vote']);
Route::post('posts/{postTitle}/unvote',[VoteController::class,'unvote']);

//adding a tag to existing post.
Route::post('posts/{postTitle}/tag',[TagController::class,'addTag']);

//getting all tag names in an array
Route::get('/tags',[TagController::class,'index']);


//-----------------------------------
//user profile section.

//the profile of the current loged in user.
Route::any('me', [UserProfileController::class,'me']);
//get all the users name.
Route::get('users',[UserProfileController::class,'index']);
//view the profile of any user. put the user name in {name}
//to show it's profile
Route::get('users/{name}',[UserProfileController::class,'show']);

//to subscribe to himser.put the user name in {name}
//to subscribe to him
Route::post('users/{name}/subscribe',[SubscribeController::class,'subscribe']);
//to unsubscribe
Route::post('users/{name}/unsubscribe',[SubscribeController::class,'unsubscribe']);
//to know if it is subscribed. return {subscribe:true}, if it is subscribed to that user.
Route::post('users/{name}/isSubscribed',[SubscribeController::class,'isSubscribed']);

Route::redirect('/', 'posts', 301);

Route::get('get_posts',[HRP::class,'get_posts']);



Route::get('search/tag/{tag}',[SearchController::class,'searchByTag']);
Route::get('search/word/{word}',[SearchController::class,'searchByWord']);
Route::get('search/user/{user}',[SearchController::class,'searchByUser']);
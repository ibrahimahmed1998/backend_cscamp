<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;

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

Route::post('/signup', [Authentication::class, 'signup']);
Route::post('/login', [Authentication::class, 'login']);
Route::post('/logout', [Authentication::class, 'logout']);


Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store']);
Route::get('/posts/{title}', [PostController::class, 'show']);
Route::post('/posts/{title}/edit', [PostController::class, 'update']);
Route::delete('/posts/{title}', [PostController::class, 'destroy']);

//add comment to a specific post 
//inputs: comment, and a title in the url path.  
Route::post("/posts/{post:title}/addComment",[CommentController::class, 'addComment']);

//to vote for some post, replace postTitle with the title of the post
//and you have to be logged in.
Route::post('posts/{postTitle}/vote',[VoteController::class,'vote']);


//the profile of the current loged in user.
Route::any('me', [UserProfileController::class,'me']);
//view the profile of any user. put the user name in {name}
//to show it's profile
Route::get('users/{name}',[UserProfileController::class,'show']);

//subscribe to any user.put the user name in {name}
//to subscribe to him
Route::post('subscribeTo/{name}',[UserProfileController::class,'subscribeTo']);

Route::redirect('/', 'posts', 301);



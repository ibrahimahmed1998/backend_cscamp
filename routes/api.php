<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllerr\PostController;
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


Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::patch('posts/{id}', [PostController::class, 'update']);
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

//the profile of the current loged in user.
Route::any('me', [UserProfileController::class,'me']);
Route::get('users/{user:name}',[UserProfileController::class,'show']);

Route::get('/', function () {return view('welcome');});



<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;
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

//Auth
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


//Post
Route::get('/index', [PostController::class, 'index']);
Route::post('/store', [PostController::class, 'store']);
Route::get('/show/{id}', [PostController::class, 'show']);
Route::post('/update/{title}', [PostController::class, 'update']);
Route::get('/deleteposts/{title}', [PostController::class, 'deleteposts']);
Route::post('/addcomment', [CommentController::class, 'addcomment']);
Route::post('/addtag', [TagController::class, 'addtag']);
Route::post('/vote', [VoteController::class, 'vote']);
//Route::middleware('auth:api')->post('/vote/{comment_id}',[VoteController::class, 'vote']);




//Route::get('/', function () {return view('welcome');});

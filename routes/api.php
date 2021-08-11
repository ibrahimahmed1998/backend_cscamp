<?php

use App\Http\Controllers\auth;
use App\Http\Controllers\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//the profile of the current loged in user.
Route::any('me', [UserProfileController::class,'me']);


Route::get('/', function () {return view('welcome');});



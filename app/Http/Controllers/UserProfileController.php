<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UserProfileController extends Controller
{

    public function __construct()
    {
        //let it be for 'me' only for now.
        $this->middleware('auth:api')->only(['me']);
    }


    public function me(Request $request)
    {
        if($user = User::where('api_token', $request->bearerToken())->first())
        {
            return response()->json(
        [
            'name' => $user->name,
            'phone' =>$user->phone,
            'followers' =>$user->followers,
            'following' =>$user->following,
            'posts' => $user->posts,
        ]);
        }
        else
        return response()->json(['message' => 'unauthenticated..']);
    }
    public function index()
    {
        return ['users' => User::all()->pluck('name')];        
    }
    public function show(Request $request,$name)
    {
        $user = User::where('name',$name)->first();        
        if($user)
        {
        //to know is the loged in user is subscribed to the visited 
        //user or not, we used a isSubscribedTo function.            
            $currentUser = User::where('api_token', $request->bearerToken())->first();
            $subscribed = $currentUser?$currentUser->isSubscribedTo($user):null;
            return response()->json(
                [
                    'name' => $user->name,
                    'posts' => $subscribed?$user->posts:$user->posts()->where('privacy',0)->get(),
                    'followers' =>$user->followers,
                    'following' =>$user->following
                ]);

        }
        else
        {
            return response(['message' => 'There is No user with that name'],404);
        }
    }
}

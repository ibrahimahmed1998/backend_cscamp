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
            'following' =>$user->following
        ]);
        }
        else
        return response()->json(['message' => 'unauthenticated..']);
    }

    public function show($name)
    {
        $user = User::where('name',$name)->first();
        if($user)
        {
            return response()->json(
                [
                    'name' => $user->name,
                    'posts' => $user->posts,
                    'followers' =>$user->followers,
                    'following' =>$user->following
                ]);
        }
        else
        {
            return response(['message' => 'There is No user with that name'],404);
        }
    }

    public function subscribe(Request $request, $userName)
    {
        $user = User::where('name', $userName)->first();
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        if(!$user)return ['message'=>'No such a user with that name'];
        if($currentUser)
        {
            $currentUser->subscribeTo($user);
            return response(['success' => 'Subscribing request has been sent.']);
        }
        return response(['message' => 'Unauthenticated']);
    }
    public function unsubscribe(Request $request, $userName)
    {
        $user = User::where('name', $userName)->first();
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        if(!$user)return ['message'=>'No such a user with that name'];
        if(!$currentUser)
        return response(['message' => 'Unauthenticated']);
        $currentUser->unsubscribeTo($user);
        return response(['success' => 'unsubscribed successfully.']);

    }

    public function isSubscribed(Request $request, $userName)
    {
        $user = User::where('name', $userName)->first();
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        if(!$user)return ['message'=>'No such a user with that name'];
        if(!$currentUser)
        return response(['message' => 'Unauthenticated']);
        return ['subscribed' => $currentUser->isSubscribedTo($user)];
    }
}

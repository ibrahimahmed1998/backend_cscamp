<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SubscribeController extends Controller
{

    public function subscribe(Request $request, $userName)
    {
        $user = User::where('name', $userName)->first();
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        if(!$user)return ['message'=>'No such a user with that name'];
        if($user == $currentUser)return ['message'=>'you can\'t subscribe to yourself'];
        
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
        if(!$currentUser)return response(['message' => 'Unauthenticated']);
        if($user == $currentUser)return ['message'=>'you can\'t unsubscribe to yourself'];
        if($currentUser->isSubscribedTo($user))
        {
            $currentUser->unsubscribeTo($user);
            return response(['success' => 'unsubscribed successfully.']);
        }
        else return response(['message' => 'you are not following that user to be able to unsubscribe ']);
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

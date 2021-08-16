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

    public function show(User $user)
    {
        if($user)
        {
            return response()->json(
                [
                    'name' => $user->name,
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

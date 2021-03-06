<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Authentication extends Controller
{
    public function __construct() {  $this->middleware('auth:api', ['except' => ['signup','login']]); }

    public function signup(Request $r){

        $token = $r->bearerToken();

        if ($token){

            $user = User::where('remember_token',$token )->first();

            if($user){ return redirect('/');  }
         }

        $r->validate(['name' => 'required|min:3|max:20|string',
                      'email' => 'required|email:rfc,dns|unique:users',
                      'phone' => 'required|numeric|regex:/(01)\d{9}/|digits:11|unique:users']);

        $user = User::create(['name'=>$r->name,   'email'=>$r->email,   'phone'=>$r->phone,]);

            return response()->json(['success' =>$user], 201);
    }

    public function login(Request $r){

        $r->validate([ 'email' => 'required|email:rfc,dns|exists:users']);

        $user = User::where('email',$r->email)->first();

        if($user){

           $user->api_token = Str::random(60) ;     $user->save();

           Auth::loginUsingId($user->id)   ;

           return response()->json(['success' => ["token"=>$user->api_token]],201);
        }
    }

    public function logout(Request $r){

        $user = User::where('api_token',$r->bearerToken())->first();

        if($user){

            $user->api_token ="";  $user->save();

            return response()->json(['success' =>'logout'] , 201);
        }
    }
}

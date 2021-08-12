<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct() {  $this->middleware('auth:api', ['except' => ['signup','login']]); }

    public function signup(Request $request){

        $token = $request->bearerToken();

        if ($token){

            $user = User::where('remember_token',$token )->first();

            if($user){ return redirect('/');  }
         }

         $request->validate(['name' => 'required|min:3|max:20|string',
                      'email' => 'required|email:rfc,dns|unique:users',
                      'phone' => 'required|numeric|regex:/(01)\d{9}/|digits:11|unique:users,phone']);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            ]);

            return response()->json(['success' =>$user], 201);
    }

    public function login(Request $request){

        $request->validate([ 'email' => 'required|email:rfc,dns|exists:users']);

        $user = User::where('email',$request->email)->first();

        if($user){

           $user->api_token = Str::random(60) ;     $user->save();

           Auth::loginUsingId($user->id)   ;

           return response()->json(['success' => ["token"=>$user->api_token]],201);
        }
    }

    public function logout(Request $request){

        $user = User::where('api_token',$request->bearerToken())->first();

        if($user){

            $user->api_token ="";
             $user->save();

            return response()->json(['success' =>'logout'] , 201);
        }
    }
}

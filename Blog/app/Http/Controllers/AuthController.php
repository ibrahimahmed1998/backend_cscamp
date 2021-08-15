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

         $fields = $request->validate([
                    'name' => 'required|min:3|max:20|string',
                    'email' => 'required|email:rfc,dns|unique:users',
                    'phone' => 'required|numeric|regex:/(01)\d{9}/|digits:11|unique:users,phone'
                ]);

        $user = User::create([
            'name'=>$fields['name'],
            'email'=>$fields['email'],
            'phone'=>$fields['phone'],
            ]);

        $token=$user->api_token = Str::random(60);

        $response=[
            'user'=>$user,
        ];

        return response($response,201);

    }

    public function login(Request $request){

        /*$request->validate([ 'email' => 'required|email:rfc,dns|exists:users']);

        $user = User::where('email',$request->email)->first();

        if($user){

           $user->api_token = Str::random(60) ;     $user->save();

           Auth::loginUsingId($user->id)   ;

           return response()->json(['success' => ["token"=>$user->api_token]],201);
        }*/

         $fields = $request->validate([

                    'email' => 'required|email:rfc,dns',

                ]);
                $user = User::where('email',$request->email)->first();

       /* $user = User::create([
            //'name'=>$fields['name'],
            'email'=>$fields['email'],
            //'phone'=>$fields['phone'],
            ]);*/

        $token=$user->api_token = Str::random(60);
        $user->save(); 
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        $user=auth()->user();
        return response($response,201);

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

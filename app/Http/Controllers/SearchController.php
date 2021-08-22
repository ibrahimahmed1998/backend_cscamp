<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;

class SearchController extends Controller
{
    //
    public function searchByWord(Request $request, $word)
    {
        
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        $publishers = $currentUser?$currentUser->following:null;
        $posts = Post::where('privacy',0)->where('body','like',"%$word%")->get();
        foreach ($publishers as $publisher) {
            $post = $publisher->posts()->where('body','like',"%$word%")->get();
            $posts = $posts->concat($post);
        }
        return $posts;
    }

    public function searchByTag($tag)
    {
        $tag = Tag::where('tag', $tag)->first();
        return $tag->posts;
    }

    public function searchByUser(Request $request, $user)
    {
        $user = User::where('name',$user)->first();
        $currentUser = User::where('api_token', $request->bearerToken())->first();
        $subscribed = $currentUser?$currentUser->isSubscribedTo($user):null;
        return !$subscribed?$user->posts()->where('privacy',0)->get():$user->posts;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;


class VoteController extends Controller
{

    public function vote(Request $request, $postTitle)
    {
        $user = User::where('api_token', $request->bearerToken())->first();
        $post = Post::where('title', $postTitle)->first();
        if(!$post)return ['message' => 'there is no such a post with that title'];
        if(!$user)return ['message' => 'you have to login'];
        try
        {
            $vote=new Vote();
            $vote->user_id=$user->id;
            $vote->post_id=$post->id;
            $vote->vote_value=1;
            $vote->save();
            return response(['success' => 'you voted for the post with the title: ' . $post->title ]);
        }
        catch (\Throwable $th) {
            if($th->errorInfo[0] = 23000)
                return ['message' => 'you\'ve already voted to this post'];
            else return $th;
        }
    }

    public function unvote(Request $request, $postTitle)
    {
        $user = User::where('api_token', $request->bearerToken())->first();
        $post = Post::where('title', $postTitle)->first();
        if(!$post)return ['message' => 'there is no such a post with that title'];
        if(!$user)return ['message' => 'you have to login'];
        try {
            $voted = Vote::where('user_id',$user->id)->where('post_id',$post->id)->delete();        
            if($voted)
            return response(['success' => 'you unvoted the post with the title: ' . $post->title ]);
            else 
            return response(['message' => 'you haven\'t voted before to be able to unvote it. ']);
        } catch (\Throwable $th) {
            return ['message' => $th];
        }
    }
}

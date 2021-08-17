<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

    public function vote(Request $request, $postTitle)
    {
        // $request ->validate([
        //     'user_id'=>'required',
        //     //'post_id'=>'required',
        //     'comment_id'=>'required',
        //     'vote_value'=>'required'
        // ]);

        $user = User::where('api_token', $request->bearerToken())->first();
        $post = Post::where('title', $postTitle)->first();
        if($user)
        {
            $vote=new Vote();
            $vote->user_id=$user->id;
            $vote->post_id=$post->post_id;
            $vote->vote_value=1;
            $vote->save();
            return response(['success' => 'you voted for the post' . $post->title ]);
        }
        else
        {
            return ['message' => 'you have to login'];
        }


        /*  $tag= new Tag();

        $tag->user_id=$request->user_id;
        $tag->post_id=$request->post_id;
        $tag->tag=$request->tag;
        $tag->save();
        return $tag;*/



        /* $vote->user_id=$request->user_id;
        $vote->post_id=$request->post_id;
        $comment->comment_id=$request->comment_id;

        $comment->save();*/

        //return Vote::create($request->all());

    // }
    /*else {
        return 'Please Log in to vote';
    }*/


    }
}

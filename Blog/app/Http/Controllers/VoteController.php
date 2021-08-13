<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

        public function vote(Request $request)
        {
            //if(Auth::user()){
                $request ->validate([
                    'user_id'=>'required',
                    //'post_id'=>'required',
                    'comment_id'=>'required',
                    'vote_value'=>'required'
                ]);

                $vote=new Vote;
                $vote->user_id=$request->user_id;
                //$vote->post_id=$request->post_id;
                $vote->comment_id=$request->comment_id;
                $vote->vote_value=$request->vote_value;
                $vote->save();
                return $vote;




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

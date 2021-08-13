<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{

        public function vote(Request $request)
        {
            if(Auth::user()){
                $request ->validate([
                    'user_id'=>'required',
                    'post_id'=>'required',
                    'comment_id'=>'required',
                    'vote_value'=>'required'
                ]);

                $comment=new Vote;
                $comment->user_id=$request->user_id;
                $comment->post_id=$request->post_id;
                $comment->comment_id=$request->comment_id;
                $comment->vote_value=$request->vote_value;
                $comment->save();
            }
            else {
                return 'Please Log in to vote';
            }

            //$this->votes_sum += $value;
        }
}

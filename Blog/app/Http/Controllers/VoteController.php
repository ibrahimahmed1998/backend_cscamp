<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;

class VoteController extends Controller
{
        //public $comment_id;
        //public $votes_sum;
        //public $value=0;
        //public $voted=false;

        public function vote(Request $request)
        {

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
            //$this->votes_sum += $value;
        }
}

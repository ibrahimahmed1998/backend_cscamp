<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Vote;
use App\Models\Post;

class CommentController extends Controller
{

    public function addComment(Request $request)
    {
        //if(Auth::check()){
            $request ->validate([
                'comment'=>'required',
                'user_id'=>'required',
                'post_id'=>'required'
            ]);

            $comment=new Comment();
            $comment->comment=$request->comment;
            $comment->user_id=$request->user_id;
            $comment->post_id=$request->post_id;
            $comment->save();
            return $comment;

            //$comment->user_id=$request->user_id;//$request->user()->id;
            //$comment->post_id=$request->post_id;
          /*
            $comment->save();
            return $comment . response()->json(['success','The Comment has been added'],200);
            return 'Please Log in to add comment';*/
            //return Comment::create($request->all());


        //}
        /*else {
            return 'error';
        }*/


    }


}

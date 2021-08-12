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
        $request ->validate([
            'comment'=>'required'
        ]);
        //$post=Post::where('id',$id);
        $comment=new Comment();
        $comment->user_id=$request->user_id;//$request->user()->id;
        $comment->post_id=$request->post_id;
        $comment->comment=$request->comment;
        $comment->save();
        return $comment . response()->json(['success','The Comment has been added'],200);

    }


}

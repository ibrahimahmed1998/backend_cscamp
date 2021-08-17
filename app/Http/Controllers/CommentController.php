<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\Vote;
use App\Models\Post;
use App\Models\User;
class CommentController extends Controller
{

    public function addComment(Request $request,  $postTitle)
    {
        if($user = User::where('api_token',$request->bearerToken())->first())
        {
            $post = Post::where('title',$postTitle)->first();
            if(!$post)return ['message' => 'there is no post with that title'];

            $request ->validate([
                'comment'=>'required',
                // 'user_id'=>'required',
                // 'post_id'=>'required'
            ]);

            $comment=new Comment();
            $comment->comment=$request->comment;
            $comment->user_id=$user->id;
            $comment->post_id=$post->id;
            $comment->save();
            // return $comment;
            return response(['success' => 'the comment has been added.','comment info' => $comment]);
        }
        else
        {
            return response(['message' => 'unauthenticated']);
        }

    }


}

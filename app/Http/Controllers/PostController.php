<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;

use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all the public posts.
            $post=Post::where('privacy',0)->get();
            return $post;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            if($user = User::where('api_token',$request->bearerToken())->first())
            {
            $request->validate([
                'title' => 'required|unique:posts,title',
                'body' => 'required',
                ]);
            $post= new Post();
            $post->title=$request->title;
            $post->body=$request->body;
            $post->user_id=$user->id;
            $request->privacy?$post->privacy = $request->privacy:0;
            $post->save();
            return response(['success' => $post]);
        }
       else {
            return response(['message'=>'Unauthenticated. Please Log in to add post'],401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($title)
    {

        $post= Post::where('title',$title)->first();
        if($post)
        {
            $post->comments = $post->comments; ///// ?????
            $post->votes = $post->votes()->count();
            $post->tags = $post->tags()->pluck('tag');
            return $post;
        }
        else
        return response(['message' => 'there is no such a title']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $title)
    {
        if($user = User::where('api_token',$request->bearerToken())->first())
        {
            Post::where('title',$title)
            ->update([
                'title'=>$request->input('title'),
                'body'=>$request->input('body')
            ]);
            return response()->json(['success'=>'The Post has been updated'],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $title)
    {
        //ensure that each user can only delete his own post.
        if($user = User::where('api_token',$request->bearerToken())->first())
        {
            if(Post::where('title',$title)->first()->user->id == $user->id)
            {
                Post::where('title',$title)->delete();
            }
            else
            return response(['message' => 'you can only delete your own posts']);
        }
        else
        {
            return response(['message' => 'unauthenticated']);
        }
        return response()->json(['success' => 'The Post has been deleted'],200);
    }
}

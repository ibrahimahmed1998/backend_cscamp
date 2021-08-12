<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=Post::all();
        //dd($post);
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
        //dd($request->all()); or
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'user_id' => 'required',

            ]);


        $post= new Post();
        $post->title=$request->title;
        $post->body=$request->body;
        $post->user_id=$request->user_id;
        $post->save();
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dd($post);
        $post= Post::findorfail($id);
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $request->validate([
            'title' => 'required',
            'body' => 'required|max:500',
            'user_id' => 'required',

            ]);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user_id;
        //$post->published_at = $request->published_at;

        $post->save();
        return response()->json(['The Post has been updated'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteposts( $title)
    {
        //dd($post);
        /*$post->delete();
        return response('',204);*/

        $post=Post::where('title',$title);
        $post->delete();
        return response()->json(['The Post has been deleted'],200);
    }
}

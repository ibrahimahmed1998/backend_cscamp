<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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
        //if(Auth::check()){
            $post=Post::all();
            //dd($post);
            return $post;
        //}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::check()){
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
       else {
            return 'Please Log in to add post';
        }

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
    public function update(Request $request, $id)
    {

        Post::where('id',$id)
        ->update([
            'title'=>$request->input('title'),
            'body'=>$request->input('body')
        ]);
        /*$post->update($request->all());
        $post->save();*/
        return response()->json(['The Post has been updated'],200);
        //return response()->json([$post,'The Post has been updated'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteposts( $id)
    {
        Post::destroy($id);

        return response()->json(['The Post has been deleted'],200);
    }
}

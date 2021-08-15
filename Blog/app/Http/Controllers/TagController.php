<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    public function addtag(Request $request)
    {

        //if(Auth::user()){
            $request->validate([
                'tag' => 'required',
                'user_id'=>'required',
                'post_id'=>'required'

                ]);
            $tag= new Tag();
            $tag->tag=$request->tag;
            $tag->user_id=$request->user_id;
            $tag->post_id=$request->post_id;
            $tag->save();
            return $tag;
            //return Tag::create($request->all());
        //}
        /*else {
            return 'Please Log in to add tag';
        }*/

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function addtag(Request $request)
    {
        $request ->validate([
            'tag'=>'required'
        ]);
        $tag=new Tag();
        $tag->user_id=$request->user_id;
        $tag->post_id=$request->post_id;
        $tag->tag=$request->tag;
        $tag->save();
        return $tag . response()->json(['success','The Tag has been added'],200);

    }
}

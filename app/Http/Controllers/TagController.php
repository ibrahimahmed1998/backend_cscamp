<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class TagController extends Controller
{
    public function addtag(Request $request, $postTitle, $tagName)
    {

        
        $request->validate(['tag' => 'required']);
        $existingTage = Tag::where('tag',$tagName)->first();
        $post = Post::where('title',$postTitle)->first();
        if(!$post)return ['message' => 'there is no post with that title'];
        try 
        {
            if($existingTage)
            {
                DB::table('post_tag')->insert($post->id,$existingTage->id);
                return ['success' => 'a tag '. $tagName .'is added to the post '.$postTitle];
            }
            else

            $tag= new Tag();
            $tag->tag=$request->tag;
            $tag->save();
            DB::table('post_tag')->insert($post->id,$tag->id);
            return ['success' => 'a tag '. $tagName .'is added to the post '.$postTitle];

        } 
        catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function index()
    {
        $tags = Tag::all()->pluck('tag');
        return $tags;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;

class TagController extends Controller
{
    public function addtag(Request $request, $postTitle)
    {
        $request->validate(['tag' => 'required']);
        $existingTag = Tag::where('tag',$request->tag)->first();
        $post = Post::where('title',$postTitle)->first();
        $user = User::where('api_token',$request->bearerToken())->first();
        if(!$user)
        {
            return response(['message' => 'unauthenticated']);
        }
     
        if(!$post)return ['message' => 'there is no post with that title'];
        if($post->user->id != $user->id)
        {
            return response(['message' => 'you can only tag your own posts']);                
        }
       try 
        {
            if($existingTag)
            {
                DB::table('post_tag')->insert(['post_id' => $post->id, 'tag_id' =>$existingTag->id]);
                return ['success' => 'a tag '. $request->tag .'is added to the post '.$postTitle];
            }
            else

            $tag= new Tag();
            $tag->tag=$request->tag;
            $tag->save();
            DB::table('post_tag')->insert(['post_id' => $post->id, 'tag_id' =>$tag->id]);
            return ['success' => 'a tag '. $request->tag .'is added to the post '.$postTitle];

        } 
        catch (\Throwable $th) {
            if($th->errorInfo[0] = 23000)
                return ['message' => 'this post is already taged with this tag'];
            else return $th;
        }
    }

    public function index()
    {
        $tags = Tag::all()->pluck('tag');
        return $tags;
    }
}

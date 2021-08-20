<?php
namespace App\Http\Controllers\Home;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Arr;
class HRP extends Controller{ // Class Name : Home Random Posts
    public function get_posts(Request $req){

        $user = User::where('api_token', $req->bearerToken())->first();
        $user_posts = Post::where('user_id', $user->id)->get();
        $star = $user->following->all();
        $stars[] = null;
        foreach ($star as $key => $pivot){
            $stars[] =  $pivot->pivot->publisher_id;
           }

        for ($i = 0; $i < count($stars); $i++){
            $Star_posts[]  = Post::where('user_id', $stars[$i])->get(); }

        $magic_posts = Arr::collapse([$user_posts, $Star_posts]);
        return  $magic_posts;      
    }
}

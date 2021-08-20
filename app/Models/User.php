<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
     //return a collection of the follower to that user.
    public function publish($title, $body)
    {
        $post= new Post();
        $post->title=$title;
        $post->body=$body;
        $post->user_id=$this->id;
        $post->save();
        return $post;
    }
    //return the publishers that the user is subscribed to.
    public function following()
    {
        return $this->belongsToMany(User::class,'subscriptions','subscriber_id','publisher_id');
    }
    //return the followers.
    public function followers()
    {
        return $this->belongsToMany(User::class,'subscriptions','publisher_id','subscriber_id');
    }

    //return the posts published by the user.
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

   //this function makes the current user subscribe to the intended user.
   public function subscribeTo(User $user)
   {
       DB::table('subscriptions')->insert(
           [
           'subscriber_id' => $this->id,
           'publisher_id'  =>$user->id,
           'state'=>0
           ]
       );
   }
   public function unsubscribeTo(User $user)
   {
       DB::table('subscriptions')->where('subscriber_id',$this->id)
       ->where('publisher_id',$user->id)->delete();
   }
   public function isSubscribedTo(User $user)
   {
       $sub = DB::table('subscriptions')->where('subscriber_id',$this->id)
       ->where('publisher_id',$user->id)->first();
       if($sub)
           return true;
       else return false;
   }

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
        'api_token',

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];
}

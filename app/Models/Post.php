<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;
use App\Models\Vote;
class Post extends Model
{
    use HasFactory;

    protected $fillable =['title','body'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

        /*
         * The roles that belong to the Post
         *
         * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
         */
    public function votes()
    {
        return $this->belongsToMany(Vote::class, 'votes', 'post_id', 'user_id');
    }
    public function votesCount()
    {
        $this->votes()->count();
    }

}

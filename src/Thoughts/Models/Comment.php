<?php
//File contains the class Comment with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    //inverse of the One-to-many relationship
    public function message (){
        return $this->belongsTo(Post::class, 'post_id');
    }

    //set up the inverse of the One-to-Many relationship from Users
    public function user (){
        return $this->belongsTo(User::class, 'user_id');
    }

}
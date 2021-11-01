<?php
//File contains the class Post with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    //map the one-to-many relationship
    public function comments (){
        return $this->hasMany(Comment::class, 'post_id');
    }

    //map the one-to-many relationship
    public function books (){
        return $this->belongsTo(Book::class, 'book_id');
    }

    //map the one-to-many relationship
    public function movies (){
        return $this->belongsTo(Movie::class, 'movie_id');
    }
}
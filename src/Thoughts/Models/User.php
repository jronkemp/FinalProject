<?php
//File contains the class User with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public function comments (){
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
    }
}

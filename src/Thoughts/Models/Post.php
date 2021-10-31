<?php
//File contains the class Post with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model{
    protected $table = 'posts';
    protected $primaryKey = 'post_id';
}
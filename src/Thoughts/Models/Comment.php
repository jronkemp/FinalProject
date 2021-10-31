<?php
//File contains the class Comment with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';
}
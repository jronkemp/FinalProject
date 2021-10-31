<?php
//File contains the class User with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
}
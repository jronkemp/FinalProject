<?php
/**
 * Author: Jaron Kempson
 * Date: 10/25/21
 * File: Movie.php
 * Description:
 */

namespace Thoughts\Models;


use Illuminate\Database\Eloquent\Model;

class Movie extends Model {

    protected $table = 'movies';
    protected $primaryKey = 'movie_id';


    public function posts (){
        return $this->hasMany(Post::class, 'movie_id');
    }

}
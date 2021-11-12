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

    // This function returns an array of links for pagination. The array includes links for the current, first, next, and last pages.
    public static function getLinks($request, $limit, $offset) {

        $count = self::count();

        // Get request uri and parts
        $uri = $request->getUri();
        $base_url = $uri->getBaseUrl();
        $path = $uri->getPath();

        // Construct links for pagination
        $links = array();

        $links[] = ['rel' => 'self', 'href' => $base_url . "/$path" . "?limit=$limit&offset=$offset"];
        $links[] = ['rel' => 'first', 'href' => $base_url . "/$path" . "?limit=$limit&offset=0"];

        if ($offset - $limit >= 0) {
            $links[] = ['rel' => 'prev', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . ($offset - $limit)];
        }
        if ($offset + $limit < $count) {
            $links[] = ['rel' => 'next', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . ($offset + $limit)];
        }
        $links[] = ['rel' => 'last', 'href' => $base_url . "/$path" . "?limit=$limit&offset=" . $limit * (ceil($count / $limit) - 1)];


        return $links;
    }

    public function getSortKeys($request){

        $sort_key_array = array();

        //Get querystring variables from url
        $params = $request->getQueryParams();

        if(array_key_exists('sort', $params)) {
            $sort = preg_replace('/^\[|\]$|\s+/', '', $params['sort']);
            //remove white spaces, [, and ])

            $sort_keys = explode(',', $sort); //get all the key:direction pairs
            foreach ($sort_keys as $sort_key) {
                $direction = 'asc';
                $column = $sort_key;
                if (strpos($sort_key, ':')) {
                    list($column, $direction) = explode(':', $sort_key);
                }
                $sort_key_array[$column] = $direction;
            }
        }
        return $sort_key_array;
    }

    public static function searchMovies($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('movie_id', "like", "%$terms%");
        } else {
            $query = self::where('movieTitle', 'like', "%$terms%")
                ->orWhere('movieDirector', 'like', "%$terms%");
        }

        $results = $query->get();
        return $results;
    }
}
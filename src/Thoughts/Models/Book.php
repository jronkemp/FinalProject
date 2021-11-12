<?php
/**
 * Author: Jaron Kempson
 * Date: 10/25/21
 * File: Book.php
 * Description:
 */

namespace Thoughts\Models;


use Illuminate\Database\Eloquent\Model;

class Book extends Model {

    protected $table = 'books';
    protected $primaryKey = 'book_id';

    //map the one-to-many relationship
    public function posts (){
        return $this->hasMany(Post::class, 'book_id');
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

    public static function searchBooks($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('book_id', "like", "%$terms%");
        } else {
            $query = self::where('bookTitle', 'like', "%$terms%")
                ->orWhere('bookAuthor', 'like', "%$terms%");
        }

        $results = $query->get();
        return $results;
    }
}
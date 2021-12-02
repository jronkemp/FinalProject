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

    //map the one-to-many relationship
    public function user (){
        return $this->belongsTo(User::class, 'user_id');
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

    public static function searchPosts($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('post_id', "like", "%$terms%")
                ->orWhere('user_id', 'like', "%$terms%");
        } else {
            $query = self::where('title', 'like', "%$terms%")
                ->orWhere('content', 'like', "%$terms%");
        }

        $results = $query->get();
        return $results;
    }

    //get all users
    public static function getPosts()
    {
        //all() method only retrieves the comments.
        $posts = self::all();
        return $posts;
    }

    //get a user by id
    public static function getPostById($id)
    {
        $post = self::findOrFail($id);
        return $post;
    }

    //get all comments posted by a user
    public static function getCommentsByPost($id)
    {
        $comments = self::findOrFail($id)->comments;
        return $comments;
    }

    // Create a new user
    public static function createPost($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Create a new User instance
        $user = new User();

        // Set the user's attributes
        foreach ($params as $field => $value) {

            // Need to hash password
            if ($field == 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }

            $user->$field = $value;
        }

        // Insert the user into the database
        $user->save();
        return $user;
    }

    // Update a user
    public static function updatePost($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the user's id from url and then the user from the database
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);

        // Update attributes of the professor
        $user->email = $params['email'];
        $user->username = $params['username'];
        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);

        // Update the professor
        $user->save();
        return $user;
    }

    // Delete a user
    public static function deletePost($id)
    {
        $user = self::findOrFail($id);
        return ($user->delete());
    }

}
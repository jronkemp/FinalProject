<?php
//File contains the class Comment with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model{
    protected $table = 'comments';
    protected $primaryKey = 'comment_id';

    //inverse of the One-to-many relationship
    public function post (){
        return $this->belongsTo(Post::class, 'post_id');
    }

    //set up the inverse of the One-to-Many relationship from Users
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

    public static function searchComments($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('comment_id', "like", "%$terms%");
        } else {
            $query = self::where('content', 'like', "%$terms%");
        }

        $results = $query->get();
        return $results;
    }

    //get all comments
    public static function getComments()
    {
        //all() method only retrieves the comments.
        $comments = self::all();
        return $comments;
    }

    //get a comment by id
    public static function getCommentById($id)
    {
        $comment = self::findOrFail($id);
        return $comment;
    }

    // Create a new comment
    public static function createComment($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Create a new User instance
        $comment = new Comment();

        // Set the comments's attributes
        foreach ($params as $field => $value) {

            $comment->$field = $value;
        }

        // Insert the user into the database
        $comment->save();
        return $comment;
    }

    // Update a comment
    public static function updateComment($request)
    {

        //Retrieve the comment's id from url and then the comment from the database
        $id = $request->getAttribute('id');
        $comment = self::findOrFail($id);

        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        // Update attributes of the comment
        foreach ($params as $field => $value) {

            $comment->$field = $value;
        }


        // Update the comment
        $comment->save();
        return $comment;
    }

    // Delete a comment
    public static function deleteComment($id)
    {
        $comment = self::findOrFail($id);
        return ($comment->delete());
    }
}
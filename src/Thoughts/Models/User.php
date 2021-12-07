<?php
//File contains the class User with the table and primary key.
namespace Thoughts\Models;

use Illuminate\Database\Eloquent\Model;
use Firebase\JWT\JWT;


class User extends Model{

    const JWT_KEY = 'my signature';
    const JWT_EXPIRE = 3600;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public function comments (){
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'user_id');
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

    public static function searchUsers($terms)
    {
        if (is_numeric($terms)) {
            $query = self::where('user_id', "like", "%$terms%");
        } else {
            $query = self::where('firstname', 'like', "%$terms%")
                ->orWhere('lastname', 'like', "%$terms%");
        }

        $results = $query->get();
        return $results;
    }


    //get all users
    public static function getUsers()
    {
        //all() method only retrieves the users.

        return self::all();
    }


    //get a user by id
    public static function getUserById($id)
    {
        return self::findOrFail($id);
    }

    //get all messages post by a user
    public static function getPostsByUser($id)
    {
        $posts = self::findOrFail($id)->posts;
        return $posts;
    }

    //get all comments posted by a user
    public static function getCommentsByUser($id)
    {
        $comments = self::findOrFail($id)->comments;
        return $comments;
    }

    // Create a new user
    public static function createUser($request)
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
    public static function updateUser($request)
    {
        // Retrieve parameters from request body
        $params = $request->getParsedBody();

        //Retrieve the user's id from url and then the user from the database
        $id = $request->getAttribute('id');
        $user = self::findOrFail($id);

        // Update attributes of the user
//        $user->email = $params['email'];
//        $user->username = $params['username'];
//        $user->password = password_hash($params['password'], PASSWORD_DEFAULT);

        foreach ($params as $field => $value) {

            $user->$field = $value;
        }

        // Update the user
        $user->save();
        return $user;
    }

    // Delete a user
    public static function deleteUser($id)
    {
        $user = self::findOrFail($id);
        return ($user->delete());
    }

    // Authenticate a user by username and password. Return the user.
    public static function authenticateUser($username, $password) {

        $user = self::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password) ? $user : false;
    }

    public static function generateJWT($id)
    {
        // Data for payload
        $user = $user = self::findOrFail($id);
        if (!$user) {
            return false;
        }

        $key = self::JWT_KEY;
        $expiration = time() + self::JWT_EXPIRE;
        $issuer = 'mychatter-api.com';

        $token = [
            'iss' => $issuer,
            'exp' => $expiration,
            'isa' => time(),
            'data' => [
                'uid' => $id,
                'name' => $user->username,
                'email' => $user->email,
            ]
        ];
        // Generate and return a token
        return JWT::encode(
            $token,   // data to be encoded in the JWT
            $key,    // the signing key
            'HS256'   // algorithm used to sign the token; defaults to HS256
        );
        // return Token::create($userId, $secret, $expiration, $issuer);
    }

    // Verify a token
    public static function validateJWT($token)
    {
        $decoded = JWT::decode($token, self::JWT_KEY, array('HS256'));
        // print_r($decoded); exit;
        return $decoded;

    }

}

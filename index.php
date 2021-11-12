<?php
/**
 * Author: Jaron Kempson
 * Date: 10/25/21
 * File: index.php
 * Description:
 */

require __DIR__."/vendor/autoload.php";
require __DIR__."/bootstrap.php";

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Book;
use Thoughts\Models\Movie;
use Thoughts\Models\User;
use Thoughts\Models\Post;
use Thoughts\Models\Comment;


//Shows the message "Hello, this is the homepage".
$app->get('/', function($request, $response, $args){
    return $response->write("Hello, this is the Thoughts homepage.");
});

/* These are the endpoints that access the book related resources

 * /books
 * /books/{id}
 * /books/{id}/posts
 *
 * TODO: Add CRUD related functions, fix empty payload error for search
 *
 * */


//GET all books
$app->get("/books", function (Request $request, Response $response, array $args){

    //Get the total number of books
    $count = Book::count();

    //Get querystring variable from url
    $params = $request->getQueryParams();

    //Do limit and offset exist?
    $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 3;//items per page

    $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;// offset of the first item

    //Get search terms
    $term = array_key_exists('q', $params) ? $params['q'] : null;

    if (!is_null($term)) {

        $books = Book::searchBooks($term);
        $payload_final = [];

        foreach ($books as $book) {
            $payload[$book->book_id] = [
                'bookTitle' => $book->bookTitle,
                'bookAuthor' => $book->bookAuthor,
                'bookISBN' => $book->bookISBN,
                'bookReleaseDate' => $book->bookReleaseDate,
                'bookCoverImage' => $book->bookCoverImage
            ];
        }
    } else {

        //Pagination
        $links = Book::getLinks($request, $limit, $offset);

        // sort the books based on parameters
        $sort_key_array = Book::getSortKeys($request);
        $query = Book::with('posts');

        $query = $query->skip($offset)->take($limit);  // limit the rows

        // sort the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {

            $query->orderBy($column, $direction);

        }

        $books = $query->get();
        $payload = [];

        foreach ($books as $book) {
            $payload[$book->book_id] = [
                'bookTitle' => $book->bookTitle,
                'bookAuthor' => $book->bookAuthor,
                'bookISBN' => $book->bookISBN,
                'bookReleaseDate' => $book->bookReleaseDate,
                'bookCoverImage' => $book->bookCoverImage
            ];
        }

        $payload_final = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $payload
        ];

    }

    //return a success code with the payload
    return $response->withStatus(200)->withJson($payload_final);

});

//GET a books info using the book_id
$app->get("/books/{id}", function (Request $request, Response $response, array $args){
    $id = $args['id'];

    $book = new Book();
    $_book = $book->find($id);

    $payload[$_book->book_id] = [
        'bookTitle' => $_book->bookTitle,
        'bookAuthor' => $_book->bookAuthor,
        'bookISBN' => $_book->bookISBN,
        'bookReleaseDate' => $_book->bookReleaseDate,
        'bookCoverImage' => $_book->bookCoverImage
    ];

    return $response->withStatus(200)->withJson($payload);
});

//get all posts associated with a book
$app -> get('/books/{id}/posts', function(Request $request, Response $response, array $args){

    $id = $args['id'];
    $book = new Book();
    $posts = $book->find($id) -> posts;

    $payload = [];

    foreach ($posts as $post){
        $payload[$post->post_id] = [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'book_id' => $post->book_id,
            'movie_id' => $post->movie_id,
            'createdAt' => $post->createdAt
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});


/* These are the endpoints that access the movie related resources

 * /movies
 * /movies/{id}
 * /movies/{id}/posts
 *
 * TODO: Add CRUD related functions, fix empty payload error for search
 *
 * */

//GET all movies
$app->get("/movies", function (Request $request, Response $response, array $args){
    //Get the total number of movies
    $count = Movie::count();

    //Get querystring variable from url
    $params = $request->getQueryParams();

    //Do limit and offset exist?
    $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 3;//items per page

    $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;// offset of the first item

    //Get search terms
    $term = array_key_exists('q', $params) ? $params['q'] : null;

    if (!is_null($term)) {

        $movies = Movie::searchMovies($term);
        $payload_final = [];

        foreach ($movies as $movie){
            $payload[$movie->movie_id] = [
                'movieTitle' => $movie->movieTitle,
                'movieDirector' => $movie->movieDirector,
                'movieReleaseDate' => $movie->movieReleaseDate,
                'movieCoverImage' => $movie->movieCoverImage
            ];
        }
    } else {

        //Pagination
        $links = Movie::getLinks($request, $limit, $offset);

        // sorting mechanics for the movies
        $sort_key_array = Movie::getSortKeys($request);
        $query = Movie::with('posts');

        $query = $query->skip($offset)->take($limit);  // limit the rows

        // sort the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {

            $query->orderBy($column, $direction);

        }

        $movies = $query->get();
        $payload = [];

        foreach ($movies as $movie){
            $payload[$movie->movie_id] = [
                'movieTitle' => $movie->movieTitle,
                'movieDirector' => $movie->movieDirector,
                'movieReleaseDate' => $movie->movieReleaseDate,
                'movieCoverImage' => $movie->movieCoverImage
            ];
        }

        $payload_final = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $payload
        ];

    }

    //return a successful code with the payload
    return $response->withStatus(200)->withJson($payload_final);

});

//GET a movies info using the movie_id
$app->get("/movies/{id}", function (Request $request, Response $response, array $args){
    $id = $args['id'];

    $movie = new Movie();
    $_movie = $movie->find($id);

    $payload[$_movie->movie_id] = [
        'movieTitle' => $_movie->movieTitle,
        'movieDirector' => $_movie->movieDirector,
        'movieReleaseDate' => $_movie->movieReleaseDate,
        'movieCoverImage' => $_movie->movieCoverImage
    ];

    return $response->withStatus(200)->withJson($payload);
});

// get all posts associated with a movie
$app -> get('/movies/{id}/posts', function(Request $request, Response $response, array $args){

    $id = $args['id'];
    $movie = new Movie();
    $posts = $movie->find($id) -> posts;

    $payload = [];

    foreach ($posts as $post){
        $payload[$post->post_id] = [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'book_id' => $post->book_id,
            'movie_id' => $post->movie_id,
            'createdAt' => $post->createdAt
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});


/* These are the endpoints that access the user related resources

 * /users
 * /users/{id}
 * /users/{id}/posts
 * /users/{id}/comments
 *
 * TODO: fix empty payload error for search function
 *
 * */

//GET all users
$app->get("/users", function (Request $request, Response $response, array $args){
    //Get the total number of users
    $count = User::count();

    //Get querystring variable from url
    $params = $request->getQueryParams();

    //Do limit and offset exist?
    $limit = array_key_exists('limit', $params) ? (int)$params['limit'] : 3;//items per page

    $offset = array_key_exists('offset', $params) ? (int)$params['offset'] : 0;// offset of the first item

    //Get search terms
    $term = array_key_exists('q', $params) ? $params['q'] : null;

    if (!is_null($term)) {

        $users = User::searchUsers($term);
        $payload_final = [];

        foreach ($users as $user){
            $payload[$user->user_id] = [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'username' => $user->username,
                'password'=>$user->password
            ];
        }
    } else {

        //Pagination
        $links = User::getLinks($request, $limit, $offset);

        // sorting for the users
        $sort_key_array = User::getSortKeys($request);
        $query = User::with('posts');

        $query = $query->skip($offset)->take($limit);  // limit the rows

        // sort the output by one or more columns
        foreach ($sort_key_array as $column => $direction) {

            $query->orderBy($column, $direction);

        }

        $users = $query->get();
        $payload = [];

        foreach ($users as $user){
            $payload[$user->user_id] = [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'username' => $user->username,
                'password'=>$user->password
            ];
        }

        $payload_final = [
            'totalCount' => $count,
            'limit' => $limit,
            'offset' => $offset,
            'links' => $links,
            'sort' => $sort_key_array,
            'data' => $payload
        ];

    }

    //return the payload with a successful code fo 200
    return $response->withStatus(200)->withJson($payload_final);
});

//GET a users info using the user_id
$app->get("/users/{id}", function (Request $request, Response $response, array $args){
    $id = $args['id'];

    $user = new User();
    $_user = $user->find($id);

    $payload[$_user->user_id] = [
        'firstname' => $_user->firstname,
        'lastname' => $_user->lastname,
        'email' => $_user->email,
        'username' => $_user->username,
        'password'=>$_user->password
    ];

    return $response->withStatus(200)->withJson($payload);
});

//get all comments made by a user
$app -> get('/users/{id}/comments', function(Request $request, Response $response, array $args){

    $id = $args['id'];
    $user = new User();
    $comments = $user->find($id) -> comments;

    $payload = [];

    foreach($comments as $comment){
        $payload[$comment->comment_id] = [
            'post_id' => $comment -> post_id,
            'user_id' => $comment -> user_id,
            'content' => $comment -> content,
            'createdAt' => $comment -> createdAt
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

//get all posts made by a user
$app -> get('/users/{id}/posts', function(Request $request, Response $response, array $args){

    $id = $args['id'];
    $user = new User();
    $posts = $user->find($id) -> posts;

    $payload = [];

    foreach ($posts as $post){
        $payload[$post->post_id] = [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'book_id' => $post->book_id,
            'movie_id' => $post->movie_id,
            'createdAt' => $post->createdAt
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

//create a new user using post method
$app->post('/users', function ($request, $response, $args) {

    $user = new User();

    $firstname = $request->getParsedBodyParam('firstname');
    $lastname = $request->getParsedBodyParam('lastname','');
    $email = $request->getParsedBodyParam('email','');
    $username = $request->getParsedBodyParam('username');
    $password = $request->getParsedBodyParam('password');

    $user->firstname = $firstname;
    $user->lastname = $lastname;
    $user->email = $email;
    $user->username = $username;
    $user->password = $password;

    $user->save();

    if ($user->firstname && $user->username && $user->password) {
        $payload = [
            'user_id' => $user->user_id,
            'user_uri' => '/users/' . $user->user_id
        ];

        return $response->withStatus(201)->withJson($payload);

    } else {

        return $response->withStatus(500);

    }

});

//delete a user using delete method
$app->delete('/users/{id}', function ($request, $response, $args) {

    $id = $args['id'];
    $user = User::find($id);
    $user->delete();

    if ($user->exists) {

        return $response->withStatus(500);

    } else {

        return $response->withStatus(204)->getBody()->write("User '/user/$id' has been deleted.");

    }
});

//update a current users information using patch method
$app->patch('/users/{id}', function ($request, $response, $args) {

    $id = $args['id'];
    $user = User::findOrFail($id);
    $params = $request->getParsedBody();

    foreach ($params as $field => $value) {
        $user->$field = $value;
    }

    $user->save();

    if ($user->user_id) {
        $payload = [
            'user_id' => $user->user_id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'username' => $user->username,
            'password'=>$user->password,
            'user_uri' => '/users/' . $user->user_id
        ];

        return $response->withStatus(200)->withJson($payload);

    } else {

        return $response->withStatus(500);

    }
});

/* These are the endpoints that access the post related resources

 * /posts
 * /posts/{id}
 * /posts/{id}/comments
 *
 * TODO: Add search, sort, and paginate functions
 *
 * */

//GET all posts
$app->get("/posts", function (Request $request, Response $response, array $args){
    $posts = post::all();

    $payload = [];

    foreach ($posts as $post){
        $payload[$post->post_id] = [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'book_id' => $post->book_id,
            'movie_id' => $post->movie_id,
            'createdAt' => $post->createdAt
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});

//GET a post info using the post_id
$app->get("/posts/{id}", function (Request $request, Response $response, array $args){

    $id = $args['id'];

    $post = new Post();
    $_post = $post->find($id);

    $payload[$_post->post_id] = [
        'user_id' => $_post->user_id,
        'title' => $_post->title,
        'content' => $_post->content,
        'book_id' => $_post->book_id,
        'movie_id' => $_post->movie_id,
        'createdAt' => $_post->createdAt
    ];

    return $response->withStatus(200)->withJson($payload);
});

//retrieve all comments replying to a specific post
$app -> get('/posts/{id}/comments', function(Request $request, Response $response, array $args){

    $id = $args['id'];
    $post = new Post();
    $comments = $post->find($id) -> comments;

    $payload = [];

    foreach($comments as $comment){
        $payload[$comment->comment_id] = [
            'post_id' => $comment -> post_id,
            'user_id' => $comment -> user_id,
            'content' => $comment -> content,
            'createdAt' => $comment -> createdAt
        ];
    }
    return $response->withStatus(200)->withJson($payload);
});

//create a new post using post method
$app->post('/posts', function ($request, $response, $args) {

    $post = new Post();

    $user_id = $request->getParsedBodyParam('user_id','');
    $title = $request->getParsedBodyParam('title');
    $content = $request->getParsedBodyParam('content');
    $book_id = $request->getParsedBodyParam('book_id', null);
    $movie_id = $request->getParsedBodyParam('movie_id',null);


    $post->user_id = $user_id;
    $post->title = $title;
    $post->content = $content;
    $post->book_id = $book_id;
    $post->movie_id = $movie_id;

    $post->save();

    if ($post->title && $post->content) {
        $payload = [
            'post_id' => $post->post_id,
            'post_uri' => '/users/' . $post->post_id
        ];

        return $response->withStatus(201)->withJson($payload);

    } else {

        return $response->withStatus(500);

    }

});

//delete a post using delete method
$app->delete('/posts/{id}', function ($request, $response, $args) {

    $id = $args['id'];
    $post = Post::find($id);
    $post->delete();

    if ($post->exists) {

        return $response->withStatus(500);

    } else {

        return $response->withStatus(204)->getBody()->write("Post '/posts/$id' has been deleted.");

    }
});

//update a current posts information using patch method
$app->patch('/posts/{id}', function ($request, $response, $args) {

    $id = $args['id'];
    $post = Post::findOrFail($id);
    $params = $request->getParsedBody();

    foreach ($params as $field => $value) {
        $post->$field = $value;
    }

    $post->save();

    if ($post->post_id) {
        $payload = [
            'user_id' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'book_id' => $post->book_id,
            'movie_id' => $post->movie_id,
            'created_at' => $post->created_at,
            'updated_at' => $post->updated_at,
            'post_uri' => '/posts/' . $post->post_id
        ];

        return $response->withStatus(200)->withJson($payload);

    } else {

        return $response->withStatus(500);

    }
});


/* These are the endpoints that access the comment related resources

 * /comment
 * /comment/{id}
 *
 * TODO: Add CRUD related functions, Add search, sort, and paginate functions
 *
 * */

//GET all comments
$app->get("/comments", function (Request $request, Response $response, array $args){

    $comments = Comment::all();

    $payload = [];

    foreach ($comments as $comment){
        $payload[$comment->comment_id] = [
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
            'content' => $comment->content,
            'createdAt' => $comment->createdAt
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});


//GET a comment info using the comment_id
$app->get("/comments/{id}", function (Request $request, Response $response, array $args){

    $id = $args['id'];
    $comment = new Comment();
    $_comment = $comment->find($id);

    $payload[$_comment->comment_id] = [
        'post_id' => $_comment->post_id,
        'user_id' => $_comment->user_id,
        'content' => $_comment->content,
        'createdAt' => $_comment->createdAt
    ];

    return $response->withStatus(200)->withJson($payload);
});


$app->run();
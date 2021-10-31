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

//TODO: Home Page
//Shows the repsonse "Hello, this is the homepage".
$app->get('/', function($request, $response, $args){
    return $response->write("Hello, this is the homepage.");
});

//Type hello/yourname in the url to recieve a hello message.
$app -> get('/hello/{name}', function ($request, $response, $args){
    $name = $args['name'];
    return $response->write("Hello ".$name);
}
);

//TODO: BOOK TABLE RELATED ENDPOINTS
//GET all books
$app->get("/books", function (Request $request, Response $response, array $args){
    $books = Book::all();

    $payload = [];

    foreach ($books as $book){
        $payload[$book->book_id] = [
            'bookTitle' => $book->bookTitle,
            'bookAuthor' => $book->bookAuthor,
            'bookISBN' => $book->bookISBN,
            'bookReleaseDate' => $book->bookReleaseDate,
            'bookCoverImage' => $book->bookCoverImage
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});

//GET a books info using the user_id
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

//TODO: Movie Table Related Endpoints
//GET all movies
$app->get("/movies", function (Request $request, Response $response, array $args){
    $movies = Movie::all();

    $payload = [];

    foreach ($movies as $movie){
        $payload[$movie->movie_id] = [
            'movieTitle' => $movie->movieTitle,
            'movieDirector' => $movie->movieDirector,
            'movieReleaseDate' => $movie->movieReleaseDate,
            'movieCoverImage' => $movie->movieCoverImage
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});

//GET a movies info using the user_id
$app->get("/movies/{id}", function (Request $request, Response $response, array $args){
    $id = $args['id'];

    $movie = new Movie();
    $_movie = $movie->find($id);

    $payload[$_movie->movie_id] = [
        'movieTitle' => $movie->movieTitle,
        'movieDirector' => $movie->movieDirector,
        'movieReleaseDate' => $movie->movieReleaseDate,
        'movieCoverImage' => $movie->movieCoverImage
    ];

    return $response->withStatus(200)->withJson($payload);
});

//TODO: USER TABLE RELATED ENDPOINTS
//GET all users
$app->get("/users", function (Request $request, Response $response, array $args){
    $users = user::all();

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
    return $response->withStatus(200) -> withJson($payload);
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

//TODO: POSTS TABLE RELATED ENDPOINTS
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

//TODO: COMMENTS TABLE RELATED ENDPOINTS

//GET all comments
$app->get("/comments", function (Request $request, Response $response, array $args){
    $comments = comment::all();

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
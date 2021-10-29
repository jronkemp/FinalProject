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
//HI PEPPER DOES THIS WORK :))))
echo "hey";
//Home page for the API
$app->get('/', function($request, $response, $args){
    return $response->write("Hello, this is the homepage.");
});

$app -> get('/hello/{name}', function ($request, $response, $args){
    $name = $args['name'];
    return $response->write("Hello ".$name);
}
);

//TODO: BOOK TABLE RELATED ENDPOINTS

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
$app->get("/users", function (Request $request, Response $response, array $args){
    $users = user::all();

    $payload = [];

    foreach ($users as $user){
        $payload[$user->user_id] = [
            'firstName' => $user->firstname,
            'lastName' => $user->lastname,
            'email' => $user->email,
            'username' => $user->username,
            'password' => $user->password
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});

//TODO: POSTS TABLE RELATED ENDPOINTS
$app->get("/posts", function (Request $request, Response $response, array $args){
    $posts = post::all();

    $payload = [];

    foreach ($posts as $post){
        $payload[$post->post_id] = [
            'postID' => $post->post_id,
            'userID' => $post->user_id,
            'title' => $post->title,
            'content' => $post->content,
            'bookID' => $post ->book_id
            'movieID' => $post->movie_id
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});

//TODO: COMMENTS TABLE RELATED ENDPOINTS

$app->get("/comments", function (Request $request, Response $response, array $args){
    $comments = comment::all();

    $payload = [];

    foreach ($comments as $comment){
        $payload[$comment->_id] = [
            'commentID' => $comment->comment_id,
            'postID' => $comment->post_id,
            'userID' => $comment->user_id,
            'content' => $comment->content,
        ];
    }
    return $response->withStatus(200) -> withJson($payload);
});
$app->run();
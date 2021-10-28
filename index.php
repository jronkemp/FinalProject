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

//TODO: Home Page
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

//TODO: POSTS TABLE RELATED ENDPOINTS

//TODO: COMMENTS TABLE RELATED ENDPOINTS


$app->run();
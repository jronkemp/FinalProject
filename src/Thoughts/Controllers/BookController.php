<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: BookController.php
 * Description:
 */

namespace Thoughts\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Book;

class BookController {

    //list all comments in the database
    public function index(Request $request, Response $response, array $args){
        $results = Book::getBooks();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get a comment information by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Book::getBookbyId($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Create a comment
    public function create(Request $request, Response $response, array $args) {

        // Validation has passed; Proceed to create the professor
        $book = Book::createBook($request);
        $results = [
            'status' => 'book created',
            'data' => $book
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update a comment
    public function update(Request $request, Response $response, array $args)
    {

        $book = Book::updateBook($request);
        $results = [
            'status' => 'book updated',
            'data' => $book
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete a comment
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Book::deleteBook($id);
        $results = [
            'status' => 'Book deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }



}
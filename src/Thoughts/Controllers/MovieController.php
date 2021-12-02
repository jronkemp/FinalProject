<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: MovieController.php
 * Description:
 */

namespace Thoughts\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Movie;

class MovieController {

    //list all movies in the database
    public function index(Request $request, Response $response, array $args){
        $results = Movie::getMovies();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get a movie information by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Movie::getMoviebyId($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Create a movie
    public function create(Request $request, Response $response, array $args) {

        // Validation has passed; Proceed to create the professor
        $movie = Movie::createMovie($request);
        $results = [
            'status' => 'movie created',
            'data' => $movie
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update a movie
    public function update(Request $request, Response $response, array $args)
    {

        $movie = Movie::updateMovie($request);
        $results = [
            'status' => 'book updated',
            'data' => $movie
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete a movie
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Movie::deleteMovie($id);
        $results = [
            'status' => 'Movie deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }



}
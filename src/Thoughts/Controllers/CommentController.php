<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: CommentController.php
 * Description:
 */

namespace Thoughts\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Comment;

class CommentController{

    //list all comments in the database
    public function index(Request $request, Response $response, array $args){
        $results = Comment::getComments();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get a comment information by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Comment::getCommentbyId($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Create a comment
    public function create(Request $request, Response $response, array $args) {

        // Validation has passed; Proceed to create the professor
        $comment = Comment::createComment($request);
        $results = [
            'status' => 'comment created',
            'data' => $comment
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update a comment
    public function update(Request $request, Response $response, array $args)
    {

        $comment = Comment::updateComment($request);
        $results = [
            'status' => 'comment updated',
            'data' => $comment
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete a comment
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Comment::deleteComment($id);
        $results = [
            'status' => 'Comment deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }



}
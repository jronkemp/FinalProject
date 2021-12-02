<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: PostController.php
 * Description:
 */

namespace Thoughts\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Post;

class PostController {

    //list all posts in the database
    public function index(Request $request, Response $response, array $args){
        $results = Post::getPosts();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get a post information by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Post::getPostById($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get all comments under a post
    public  function viewPostComments(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = Post::getCommentsByPost($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Create a post
    public function create(Request $request, Response $response, array $args)
    {

        // Validation has passed; Proceed to create the post
        $post = Post::createPost($request);
        $results = [
            'status' => 'user created',
            'data' => $post
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update a post
    public function update(Request $request, Response $response, array $args)
    {

        $post = Post::updatePost($request);
        $results = [
            'status' => 'user updated',
            'data' => $post
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete a post
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        Post::deletePost($id);
        $results = [
            'status' => 'Post deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }
}
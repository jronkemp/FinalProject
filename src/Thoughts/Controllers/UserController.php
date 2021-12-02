<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: UserController.php
 * Description:
 */

namespace Thoughts\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\User;

class UserController {

    //list all users in the database
    public function index(Request $request, Response $response, array $args){
        $results = User::getUsers();
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get a user information by id
    public function view(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = User::getUserById($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get all messages posted by a user
    public  function viewPosts(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = User::getPostsByUser($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    //get all comments posted by a user
    public  function viewComments(Request $request, Response $response, array $args){
        $id = $args['id'];
        $results = User::getCommentsByUser($id);
        $code = array_key_exists('status', $results) ? 500 : 200;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Create a user when the user signs up an account
    public function create(Request $request, Response $response, array $args)
    {

        // Validation has passed; Proceed to create the professor
        $user = User::createUser($request);
        $results = [
            'status' => 'user created',
            'data' => $user
        ];
        $code = array_key_exists('status', $results) ? 201 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Update a user
    public function update(Request $request, Response $response, array $args)
    {

        $user = User::updateUser($request);
        $results = [
            'status' => 'user updated',
            'data' => $user
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, $code, JSON_PRETTY_PRINT);
    }

    // Delete a user
    public function delete(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        User::deleteUser($id);
        $results = [
            'status' => 'User deleted',
        ];
        $code = array_key_exists('status', $results) ? 200 : 500;
        return $response->withJson($results, 200, JSON_PRETTY_PRINT);
    }
}
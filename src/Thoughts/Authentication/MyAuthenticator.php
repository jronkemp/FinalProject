<?php
/**
 * Author: Jaron Kempson
 * Date: 12/2/21
 * File: MyAuthenticator.php
 * Description:
 */

namespace Thoughts\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\User;

class MyAuthenticator {

    /*
     * Use the __invoke method so the object can be used as a callable
     * This method gets called automatically when the whole class is treated
as a callable.
    */

    public function __invoke(Request $request, Response $response, $next) {

        // If the header named "ChatterAPI-Authorization" does not exist,display an error
        if (!$request->hasHeader('ChatterAPI-Authorization')) {

            $results = array('status' => 'Authorization header not available');

            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // ChatterAPI-Authorization header exists, retrieve the username and password from the header

        $auth = $request->getHeader('ChatterAPI-Authorization');
        list($username, $password) = explode(':', $auth[0]);

        // Validate the header value by calling User's authenticateUser method.
        if (!User::authenticateUser($username, $password)) {

            $results = array("status" => "Authentication failed");

            return $response->withJson($results, 401, JSON_PRETTY_PRINT);
        }

        // A user has been authenticated.
        $response = $next($request, $response);
        return $response;

    }
}
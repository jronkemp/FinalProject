<?php
/**
 * Author: Jaron Kempson
 * Date: 12/2/21
 * File: BearerAuthenticator.php
 * Description:
 */

namespace Thoughts\Authentication;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Thoughts\Models\Token;

class BearerAuthenticator {

    public function __invoke(Request $request, Response $response, $next){

        // If the header named "Authorization" does not exist, display an error
        if (!$request->hasHeader('Authorization')) {

            $results = array('status' => 'Authorization header not available');

            return $response->withJson($results, 404, JSON_PRETTY_PRINT);
        }

        // ChatterAPI-Authorization header exists, retrieve the header and the header value
        $auth = $request->getHeader('Authorization');

        //The value of the authorization header consists of Bearer and the key separated by a space.
        $token = substr($auth[0], strpos($auth[0], ' ') + 1); // the key is the second part of the string after a space

        if (!Token::validateBearer($token)) {
            $results = array("status" => "Authentication failed");
            return $response->withJson($results, 401, JSON_PRETTY_PRINT);
        }

        // A user has been authenticated.
        $response = $next($request, $response);
        return $response;
    }
}
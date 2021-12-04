<?php
/**
 * Author: Jaron Kempson
 * Date: 12/1/21
 * File: routes.php
 * Description:
 */

use Thoughts\Middleware\Logging as ThoughtsLogging;
use Thoughts\Authentication\MyAuthenticator;
use Thoughts\Authentication\BasicAuthenticator;
use Thoughts\Authentication\BearerAuthenticator;

//Shows the message "Hello, this is the thoughts homepage".
$app->get('/', function($request, $response, $args){
    return $response->write("Hello, this is the Thoughts homepage.");
});

// user routes
$app->group('/users', function () {

    $this->get('', 'UserController:index');
    $this->get('/{id}', 'UserController:view');
    $this->get('/{id}/posts', 'UserController:viewPosts');
    $this->get('/{id}/comments', 'UserController:viewComments');

    $this->post('', 'UserController:create');
    $this->patch('/{id}', 'UserController:update');
    $this->delete('/{id}', 'UserController:delete');

    $this->post('/authBearer', 'UserController:authBearer');

});

$app->group('', function(){
    //post routes
    $this->group('/posts', function () {

        $this->get('', 'PostController:index');
        $this->get('/{id}', 'PostController:view');
        $this->get('/{id}/comments', 'PostController:viewPostComments');

        $this->post('', 'PostController:create');
        $this->patch('/{id}', 'PostController:update');
        $this->delete('/{id}', 'PostController:delete');

    });

    //comment routes
    $this->group('/comments', function () {

        $this->get('', 'CommentController:index');
        $this->get('/{id}', 'CommentController:view');

        $this->post('', 'CommentController:create');
        $this->patch('/{id}', 'CommentController:update');
        $this->delete('/{id}', 'CommentController:delete');

    });

    //book routes
    $this->group('/books', function () {

        $this->get('', 'BookController:index');
        $this->get('/{id}', 'BookController:view');

        $this->post('', 'BookController:create');
        $this->patch('/{id}', 'BookController:update');
        $this->delete('/{id}', 'BookController:delete');

    });

    //movie routes
    $this->group('/movies', function () {

        $this->get('', 'MovieController:index');
        $this->get('/{id}', 'MovieController:view');

        $this->post('', 'MovieController:create');
        $this->patch('/{id}', 'MovieController:update');
        $this->delete('/{id}', 'MovieController:delete');

    });
})->add(new BearerAuthenticator());

//to protect certain resources from un authenticated users we can group routes under a blank group and link this at the end

//reference practice 3,4 for more info

//$app->add(new MyAuthenticator());
//$app->add(new BasicAuthenticator());

//$app->add(new BearerAuthenticator());
//$app->add(new ThoughtsLogging());
$app->run();
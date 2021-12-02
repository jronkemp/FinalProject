<?php
/**
 * Created by Jaron Kempson
 * Date: 8/8/2019
 * File: services.php
 * Decription:
 **/

// Alias to the controllers
use Thoughts\Controllers\UserController as UserController;
use Thoughts\Controllers\PostController as PostController;
use Thoughts\Controllers\CommentController as CommentController;
use Thoughts\Controllers\BookController as BookController;
use Thoughts\Controllers\MovieController as MovieController;

/*
 * The following is the controller and middleware factory. It
 * registers controllers and middleware with the DI container so
 * they can be accessed in other classes. Injecting instances into
 * the DI container so you don't need to pass the entire container or app,
 * rather only the services needed.
 * https://akrabat.com/accessing-services-in-slim-3/#comment-35429
 */

// Register controllers with the DIC. $c is the container itself.
$container['UserController'] = function ($c) {
    return new UserController();
};

$container['PostController'] = function ($c) {
    return new PostController();
};

$container['CommentController'] = function ($c) {
    return new CommentController();
};

$container['BookController'] = function ($c) {
    return new BookController();
};

$container['MovieController'] = function ($c) {
    return new MovieController();
};
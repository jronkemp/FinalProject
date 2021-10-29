<?php
/**
 * Author: Jaron Kempson
 * Date: 10/25/21
 * File: bootstrap.php
 * Description:
 */

include 'config/credentials.php';
include 'vendor/autoload.php';

//setup the connection with the database
use Illuminate\Database\Capsule\Manager as Capsule;

$config['displayErrorDetails'] = true; //default false
$config['addContentLengthHeader'] = false; //default true

$app = new \Slim\App(["settings" => $config]);

$capsule = new Capsule();
$capsule->addConnection([
    "driver" => "mysql",
    "host" => $db_host,
    "database" => $db_name,
    "port"=>3307,
    "username" => $db_username,
    "password" => $db_password,
    "chartset" =>  "utf8",
    "collation" => "utf8_general_ci",
    "prefix" => "" //this is optional.
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

$container = $app->getContainer();
$container['db'] = function($container)use($capsule){
    return $capsule;
};
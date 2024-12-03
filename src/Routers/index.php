<?php

use Webapi\Core\Router;
$router->add("GET", "/users", "UserController@getAll");
$router->add("POST", "/users", "UserController@createUser");
$router->add("GET", "/users/{id}", "UserController@getUserById");

?>
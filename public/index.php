<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

global $users;
$users = [
    [  
        "id" => "1",
        "name" => "Ali"
    ],
    [  
        "id" => "2",
        "name" => "Veli"
    ]
];

require_once __DIR__ . "/../vendor/autoload.php";

use Webapi\Core\Router;
use Webapi\Core\Response;
use Webapi\Core\Request;

$req = new Request();
$res = new Response();
$router = new Router();

require_once __DIR__ . "/../src/Routers/index.php";

$router->dispatcher($req, $res);

?>
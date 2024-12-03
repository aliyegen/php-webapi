<?php

namespace Webapi\Core;

use Webapi\Core\Request;
use Webapi\Core\Response;

class Router {
    protected $routes = [];
    protected $targetNamespace = 'Webapi\\Controllers\\';

    public function add(string $method, string $uri, string $action){
        $uri = trim($uri, "/");
        $pattern = preg_replace("/\{([a-zA-Z0-9_]+)\}/", "([a-zA-Z0-9_-]+)", $uri);
        $pattern = "~^$pattern$~";

        $this->routes[] = [
            "method" => strtoupper($method),
            "uri" => $uri,
            "pattern" => $pattern,
            "action" => $action
        ];
    }

    public function dispatcher(Request $req, Response $res){
        $reqUri = trim($req->getUri(), "/");
        $reqMethod = strtoupper($req->getMethod());

        foreach ($this->routes as $route){
            if($route["method"] === $reqMethod && 
            preg_match($route["pattern"], $reqUri, $matches)){
                array_shift($matches);
                return $this->callController($route["action"], $matches, $req, $res);
            }
        }
        //TODO: Exception handler
        $res->json([
            "error" => "404 Not Found"
        ], 404);
    }

    protected function callController(
    string $action, 
    array $params, 
    Request $req, 
    Response $res){
        [$controller, $method] = explode("@", $action);
        $fullControllerName = $this->targetNamespace . $controller;

        if(class_exists($fullControllerName)){
            $controllerInstance = new $fullControllerName($req, $res);
            if(method_exists($controllerInstance, $method)){
                return call_user_func_array([$controllerInstance, $method], $params);
            } else {
                //TODO: Exception handler
                $res->json(['error' => 'Action not found'], 404);
            }
        } else {
             //TODO: Exception handler
            $res->json(['error' => 'Controller not found'], 404);
        }
        
        //TODO: Exception handler
       $res->json([
        "error" => "Bad Request"
       ], 400);
    }

  
}

?>
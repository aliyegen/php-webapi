<?php

namespace Webapi\Core;

use Webapi\Core\Request;
use Webapi\Core\Response;

class Router {
    protected $routes = [];
    protected $targetNamespace = 'Webapi\\Controllers\\';

    protected Request $req;
    protected Response $res;

    public function __construct(Request $req, Response $res){
        $this->req = $req;
        $this->res = $res;
    }

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

    public function dispatcher(){
        $reqUri = trim($this->req->getUri(), "/");
        $reqMethod = strtoupper($this->req->getMethod());

        foreach ($this->routes as $route){
            if($route["method"] === $reqMethod && 
            preg_match($route["pattern"], $reqUri, $matches)){
                array_shift($matches);
                return $this->callController($route["action"], $matches, $this->req, $this->res);
            }
        }
        //TODO: Exception handler
        $this->res->json([
            "error" => "404 Not Found"
        ], 404);
    }

    protected function callController(
    string $action, 
    array $params, 
    ){
        [$controller, $method] = explode("@", $action);
        $fullControllerName = $this->targetNamespace . $controller;

        if(class_exists($fullControllerName)){
            $controllerInstance = new $fullControllerName($this->req, $this->res);
            if(method_exists($controllerInstance, $method)){
                return call_user_func_array([$controllerInstance, $method], $params);
            } else {
                //TODO: Exception handler
                $this->res->json(['error' => 'Action not found'], 404);
            }
        } else {
             //TODO: Exception handler
            $this->res->json(['error' => 'Controller not found'], 404);
        }
        
        //TODO: Exception handler
       $this->res->json([
        "error" => "Bad Request"
       ], 400);
    }

  
}

?>
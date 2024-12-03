<?php

namespace Webapi\Core;

class Request {

    protected $headers;
    protected $body;
    protected $queryParams;
    protected $method;
    protected $uri;

    public function __construct(){
        $this->headers = getallheaders();
        $this->body = $this->setBody();
        $this->queryParams = $_GET;
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uri = $this->parseUri();
    }

    private function setBody(): array {
        $input = json_decode(
            file_get_contents("php://input"), true
            ) ?? $_REQUEST ?? [];

        return $input;
    }

    private function parseUri(): string {
        if (isset($_SERVER['REQUEST_URI'])) {
            $uri = $_SERVER['REQUEST_URI'];
            $parsedUrl = parse_url($uri);
            return $parsedUrl['path'] ?? '/';
        }
        return '/';
    }

    public function getHeaders(): array {
        return $this->headers;
    }

    public function getBody(): array {
        return $this->body;
    }

    public function getQueryParams(): array {
        return $this->queryParams;
    }

    public function getMethod(): string {
        return $this->method;
    }

    public function getUri(): string {
        return $this->uri;
    }
}

?>
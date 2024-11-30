<?php

namespace Webapi\Core;

class Request {

    protected $headers;
    protected $body;
    protected $queryParams;
    protected $method;
    protected $uri;

    public function __constructed(){
        $this->headers = getallheaders();
        $this->body = $this->setBody();
        $this->$queryParams = $_GET;
        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->uri = parse_url($_SERVER["REQUEST_URI"]);
    }

    private function setBody(): array {
        $input = json_decode(
            file_get_contents("php://input"), true
            ) ?? $_REQUEST ?? [];

        return $input;
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
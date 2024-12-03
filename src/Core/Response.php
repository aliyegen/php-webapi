<?php

namespace Webapi\Core;

class Response {
    protected $status;
    protected $body;

    public function setStatusCode(int $statusCode): void {
        $this->status = $statusCode;
        http_response_code($statusCode);
    }

    public function json(array $data, int $statusCode = 200): void{
        header("Content-Type: application/json");
        $this->setStatusCode($statusCode);
        echo json_encode($data);
    }
    
}

?>
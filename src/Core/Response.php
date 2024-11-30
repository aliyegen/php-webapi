<?php

namespace Webapi\Core;

class Response {
    protected $status = 200;
    protected $body;

    public function setStatusCode(int $statusCode): void {
        $this->status = $statusCode;
        http_status_code($statusCode);
    }

    public function json(array $data, int $statusCode): void{
        header("Content-Type", "application/json");
        setStatusCode($statusCode);
        echo json_encode($data);
    }
    
}

?>
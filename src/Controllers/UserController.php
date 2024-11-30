<?php
    
namespace Webapi\Controllers;
use Webapi\Core\Controller;

class UserController extends Controller {
    
    public function __construct(){
        parent::__construct($req, $res);
    }

    public function getAll(): void {
        $this->res->json([
            ["id" => "1", "name" => "User"]
        ]);
    }
}

?>
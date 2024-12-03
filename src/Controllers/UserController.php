<?php
    
namespace Webapi\Controllers;
use Webapi\Core\Controller;
use Webapi\Services\UserService;
use Webapi\Core\Request;
use Webapi\Core\Response;

class UserController extends Controller {

    private $userService;
    
    public function __construct(Request $req, Response $res){
        parent::__construct($req, $res);
        $this->userService = new UserService();

    }

    public function getAll(): void {
        $queryParams = $this->req->getQueryParams();
        $users = $this->userService->getAll($queryParams);
        $this->res->json($users, 200);
    }

    public function createUser(): void {
        
        $body = $this->req->getBody();

          //TODO: validation
          if(!isset($body["name"])){
            $this->res->json([
                "error" => '"name" is required.'
            ], 400);
            exit;
        }
        $newUser = $this->userService->createUser($body);
        $this->res->json($newUser, 201);
        
    }

    public function getUserById($id): void{
        $user = $this->userService->getUserById($id);
        $this->res->json($user);
    }
}

?>
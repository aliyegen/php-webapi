<?php

namespace Webapi\Core;
use Webapi\Core\Request;
use Webapi\Core\Response;

class Controller {
    protected $req;
    protected $res;

    public function __construct (Request $req, Response $res){
        $this->req = $req;
        $this->res = $res;
    }

}

?>
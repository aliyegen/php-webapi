<?php

namespace Webapi\Core;

class Controller {
    protected $req;
    protected $res;

    public function __construct (Request $req, Response $res){
        $this->req = $req;
        $this->res = $res;
    }

}

?>
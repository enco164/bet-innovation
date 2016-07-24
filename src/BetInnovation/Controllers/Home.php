<?php
namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Home\Index;

class Home extends Controller{

    private $view;

    public function index(){
        $this->view = new Index();
        $this->view->index();
    }

    public function test(){
        echo "Home Test controller";
    }

}
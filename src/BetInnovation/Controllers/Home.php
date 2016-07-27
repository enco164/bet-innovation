<?php
namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Home\Index;

class Home extends Controller{

    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new Index();
        $this->model = [
            'navActiveLink'=>'HOME'
        ];
    }

    public function index(){
        $this->view->render($this->model);
    }

    public function test(){
        echo "Home Test controller";
    }

}
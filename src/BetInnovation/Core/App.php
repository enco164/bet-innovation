<?php

namespace BetInnovation\Core;

use BetInnovation\Controllers\Home;

class App
{
    private $controller = "Home";
    private $method = "index";

    private $params=[];

    public function  __construct()
    {

        $url=$this->parseUrl();

        if($url != NULL && file_exists(realpath(__DIR__."/./../Controllers/".$url[0].".php"))){
            $this->controller=$url[0];
            unset($url[0]);
        }

        //echo $this->controller;

        include_once realpath(__DIR__."/./../Controllers/".$this->controller.".php");
        $this->controller = (new \ReflectionClass("BetInnovation\\Controllers\\".$this->controller))->newInstance();

        if(isset($url[1]) and method_exists($this->controller, $url[1])){
            $this->method=$url[1];
            unset($url[1]);
        }

        //echo $this->method;

        $this->params=$url ? array_values($url) : [];

        call_user_func([$this->controller, $this->method],$this->params);
    }

    private function parseUrl(){
        if(isset($_GET['url'])){
            return explode("/", filter_var(trim($_GET['url'], "/"), FILTER_SANITIZE_URL));
        }
        return NULL;
    }
}
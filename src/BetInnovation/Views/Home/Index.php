<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 24.7.16.
 * Time: 22.31
 */

namespace BetInnovation\Views\Home;


use BetInnovation\Views\View;

class Index extends View
{
    public function index()
    {
        $this->head();
        $this->header();
        echo "AAAAA";
        $this->footer();
    }
}
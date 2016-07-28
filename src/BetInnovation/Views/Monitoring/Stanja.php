<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.47
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Views\View;

class Stanja extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'STANJA';
        $this->head();
        $this->header($viewBag);
        $this->footer();
    }
}
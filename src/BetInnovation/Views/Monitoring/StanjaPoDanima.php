<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.47
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Views\View;

class StanjaPoDanima extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'STANJA_PO_DANIMA';
        $this->head();
        $this->header($viewBag);
        $this->footer();
    }
}
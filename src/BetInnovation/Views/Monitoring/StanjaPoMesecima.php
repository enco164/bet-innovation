<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.48
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Views\View;

class StanjaPoMesecima extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'STANJA_PO_MESECIMA';
        $this->head();
        $this->header($viewBag);
        $this->footer();
    }
}
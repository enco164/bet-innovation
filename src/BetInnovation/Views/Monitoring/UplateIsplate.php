<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.46
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Views\View;

class UplateIsplate extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'UPLATE_ISPLATE';

        $this->head();
        $this->header($viewBag);
        $this->footer();
    }
}
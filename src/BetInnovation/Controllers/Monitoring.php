<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.43
 */

namespace BetInnovation\Controllers;

use BetInnovation\Core\Controller;
use BetInnovation\Views\Monitoring\Stanja;
use BetInnovation\Views\Monitoring\StanjaPoDanima;
use BetInnovation\Views\Monitoring\StanjaPoMesecima;
use BetInnovation\Views\Monitoring\UplateIsplate;

class Monitoring extends Controller
{
    public function index()
    {
        header('Locaton: /');
        die();
    }

    public function uplateIsplate()
    {
        (new UplateIsplate())->render([]);
    }

    public function stanja()
    {
        (new Stanja())->render([]);
    }

    public function stanjaPoDanima()
    {
        (new StanjaPoDanima())->render([]);
    }

    public function stanjaPoMesecima()
    {
        (new StanjaPoMesecima())->render([]);
    }
}
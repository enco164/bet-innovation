<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.48
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Core\FilterGenerator;
use BetInnovation\Core\TableGenerator;
use BetInnovation\Views\View;

class StanjaPoMesecima extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'STANJA_PO_MESECIMA';
        $this->head();
        $this->header($viewBag);
        ?>
        <div class='container-fluid'>
            <div class='row'>
                <form action='/Monitoring/stanjaPoMesecima' method='post' class="form-inline" style="padding: 16px" id="filterForm">

                    <?php new FilterGenerator([
                        ["type"=>"select", "label"=> "Naziv", "name"=>"serialNum", "values"=>$viewBag['uniqueNames'] ],
                        ["type"=>"select", "label"=> "Terminal", "name"=>"terminal", "values"=>[
                            ["", "Svi zbirno"],
                            ["-1", "Svaki odvojeno"],
                            ["1", "1"],
                            ["2", "2"],
                            ["3", "3"],
                            ["4", "4"],
                            ["5", "5"],
                            ["6", "6"],
                            ["7", "7"],
                            ["8", "8"]
                        ]],
                        ["type"=>"date", "label"=> "Period od", "name"=>"datetimeFromDate"],

                        ["type"=>"date", "label"=> "Period do", "name"=>"datetimeToDate"]
                    ]);?>

                </form>

            </div>
        </div>

        <div class='container-fluid'>
            <?php
            if(count($viewBag['data']) > 0)
                new TableGenerator($viewBag['headers'], $viewBag['data']);
            else
                echo "<p style='text-align: center'>Nema rezultata</p>"
            ?>
        </div>
        <?php
        $this->footer();
    }
}
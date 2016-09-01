<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 27.7.16.
 * Time: 23.47
 */

namespace BetInnovation\Views\Monitoring;


use BetInnovation\Core\FilterGenerator;
use BetInnovation\Core\TableGenerator;
use BetInnovation\Views\View;

class Stanja extends View
{

    public function render($viewBag)
    {
        $viewBag['navActiveLink'] = 'STANJA';
        $this->head();
        $this->header($viewBag);
        ?>

<!--        <a class="btn btn-default hidden-lg hidden-md pull-right"-->
<!--           role="button" data-toggle="collapse"-->
<!--           href="#filters"-->
<!--           aria-expanded="false" aria-controls="filters" style="margin: 8px 8px">-->
<!--            <i class="fa fa-filter" aria-hidden="true"></i>-->
<!--            <span>Filteri</span>-->
<!--        </a>-->
<!--        <script>-->
<!--            $(window).bind('resize load', function() {-->
<!--                if ($(this).width() < 767) {-->
<!--                    $('#filters').removeClass('in');-->
<!--                    $('#filters').addClass('out');-->
<!--                } else {-->
<!--                    $('#filters').removeClass('out');-->
<!--                    $('#filters').addClass('in');-->
<!--                }-->
<!--            });-->
<!---->
<!--        </script>-->

        <div class='container-fluid' id="filters">
            <div class='row'>
                <form id="filters" action='/Monitoring/stanja' method='post' class="form-inline" style="padding: 16px">

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
                        ["type"=>"time", "label"=> "Vreme od", "name"=>"datetimeFromTime"],

                        ["type"=>"date", "label"=> "Period do", "name"=>"datetimeToDate"],
                        ["type"=>"time", "label"=> "Vreme do", "name"=>"datetimeToTime"]
                    ]);?>

                </form>

            </div>
        </div>
        <div class="container-fluid ">
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
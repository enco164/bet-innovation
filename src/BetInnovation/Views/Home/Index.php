<?php
/**
 * Created by PhpStorm.
 * User: enco
 * Date: 24.7.16.
 * Time: 22.31
 */

namespace BetInnovation\Views\Home;


use BetInnovation\Core\TableGenerator;
use BetInnovation\Views\View;

class Index extends View
{
    private function formatDate($d) {
        return str_replace(' 00:00:00', '', $d);
    }
    public function render($viewBag)
    {
        $this->head();
        $this->header($viewBag);

        ?>
        <div class='container-fluid'>
            <h1>Home</h1>
            <div class='row'>
                <div class="col-md-12">
                    <p class="lead">Primer grafikona (nisu uvezani sa stvarnim podacima)</p>
                </div>
                <div class="col-md-4">
                    <?php
                    if(count($viewBag['data']) > 0)
                        new TableGenerator($viewBag['headers'], $viewBag['data']);
                    else
                        echo "<p style='text-align: center'>Nema rezultata</p>"
                    ?>
                </div>
                <div class="col-md-4">
                    <canvas id="pieChart"></canvas>
                    <script>
                        jQuery(document).ready(function(){
                            var ctx2 = document.getElementById("pieChart");
                            var pieChart = new Chart(ctx2, {
                                type: 'pie',
                                data:{
                                    labels: [
                                        "Red",
                                        "Blue",
                                        "Yellow"
                                    ],
                                    datasets: [
                                        {
                                            data: [300, 50, 100],
                                            backgroundColor: [
                                                "#FF6384",
                                                "#36A2EB",
                                                "#FFCE56"
                                            ],
                                            hoverBackgroundColor: [
                                                "#FF6384",
                                                "#36A2EB",
                                                "#FFCE56"
                                            ]
                                        }]
                                }});
                        });

                    </script>
                </div>

                <div class="col-md-4">
                    <canvas id="lineChart"></canvas>
                    <script>
                        jQuery(document).ready(function(){
                            var ctx = document.getElementById("lineChart");
                            var data = {
                                labels: ["Januar", "Februar", "Mart", "April", "Maj", "Jun", "Jul"],
                                datasets: [
                                    {
                                        label: "Masina 1",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(75,192,192,0.4)",
                                        borderColor: "rgba(75,192,192,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(75,192,192,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [15, 39, 47, 51, 36, 15, 50],
                                        spanGaps: false,
                                    },
                                    {
                                        label: "Masina 2",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(225,85,84,0.4)",
                                        borderColor: "rgba(225,85,84,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(225,85,84,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(225,85,84,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [95, 29, 34, 11, 5, 52, 10],
                                        spanGaps: false,
                                    },
                                    {
                                        label: "Masina 3",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(225,188,47,0.4)",
                                        borderColor: "rgba(225,188,47,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(225,188,47,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(225,188,47,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [12, 22, 95, 33, 57, 21, 49],
                                        spanGaps: false,
                                    },
                                    {
                                        label: "Masina 4",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(59,178,115,0.4)",
                                        borderColor: "rgba(59,178,115,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(59,178,115,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(59,178,115,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [16, 26, 88, 32, 36, 31, 18],
                                        spanGaps: false,
                                    },
                                    {
                                        label: "Masina 5",
                                        fill: false,
                                        lineTension: 0.1,
                                        backgroundColor: "rgba(119,104,174,0.4)",
                                        borderColor: "rgba(119,104,174,1)",
                                        borderCapStyle: 'butt',
                                        borderDash: [],
                                        borderDashOffset: 0.0,
                                        borderJoinStyle: 'miter',
                                        pointBorderColor: "rgba(119,104,174,1)",
                                        pointBackgroundColor: "#fff",
                                        pointBorderWidth: 1,
                                        pointHoverRadius: 5,
                                        pointHoverBackgroundColor: "rgba(119,104,174,1)",
                                        pointHoverBorderColor: "rgba(220,220,220,1)",
                                        pointHoverBorderWidth: 2,
                                        pointRadius: 1,
                                        pointHitRadius: 10,
                                        data: [25, 89, 10, 61, 96, 5, 72],
                                        spanGaps: false,
                                    }
                                ]
                            };
                            var myLineChart = Chart.Line(ctx, {
                                data: data
                            });
                        });

                    </script>
                </div>
            </div>
        </div>
        </div>
        <?php

        $this->footer();
    }
}
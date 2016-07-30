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
            <div class="row">
                <?php
                    $tb = new TableGenerator($viewBag['headers'], $viewBag['data']);
                ?>
<!--                <div class="table-responsive">-->
<!--                    <table class="table table-hover table-striped table-bordered" >-->
<!--                        <thead>-->
<!--                        <tr>-->
<!--                            --><?php
//                            foreach ($viewBag['headers'] as $header) {
//                                ?>
<!--                                <th>-->
<!--                                    --><?php //echo $header['name']; ?>
<!--                                </th>-->
<!--                                --><?php
//                            }
//                            ?>
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody>-->
<!--                        --><?php
//                        foreach ($viewBag['data'] as $row) {
//                            echo "<tr>";
//                            foreach ($viewBag['headers'] as $header) {
//                                ?>
<!--                                <td class="--><?php //echo $header['native_type']; ?><!--">-->
<!--                                    --><?php
//                                    if($header['native_type']==='timestamptz') {
//                                        if($row[$header['name']])
////                                            echo date("d.m.Y H:i:s", strtotime($row[$header['name']]));
//                                            echo $this->formatDate(date("d.m.Y H:i:s", strtotime($row[$header['name']])));
//                                    }
//                                    else
//                                        echo $row[$header['name']]; ?>
<!--                                </td>-->
<!--                                --><?php
//                            }
//                            echo "</tr>";
//                        }
//                        ?>
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
            </div>
            <div class='row'>
                <div class="col-md-4">
                    <canvas id="barChart" class="col-md-4"></canvas>
                    <script>
                        jQuery(document).ready(function(){
                            var ctx = document.getElementById("barChart");
                            var pieChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                                    datasets: [{
                                        label: '# of Votes',
                                        data: [12, 19, 3, 5, 2, 3]
                                    }]
                                },
                                options: {
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero:true
                                            }
                                        }]
                                    }
                                }
                            });
                        });

                    </script>
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
                                        "Green",
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
                                labels: ["January", "February", "March", "April", "May", "June", "July"],
                                datasets: [
                                    {
                                        label: "Line Chart",
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
                                        data: [65, 59, 80, 81, 56, 55, 40],
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
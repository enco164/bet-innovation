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
            <div class="row">
                <form id="filtersForm" action='' class="form-inline" style="padding: 16px">
                    <div class="btn-group" role="group" aria-label="..." style="margin-top: 16px; margin-right: 16px">
                        <button id="po-danu" type="button" class="btn btn-default" onclick="setPodeok(0)">Po danu</button>
                        <button id="po-mesecu" type="button" class="btn btn-primary" onclick="setPodeok(1)">Po mesecu</button>
                    </div>
                    <div class="form-group">
                        <label>
                            Period od: <br/>
                            <div class='input-group input-group-sm date'>
                                <input type='text' class="form-control input-sm"
                                       id='periodStart'
                                       name="periodStart"
                                       oninput="redrawAllData()"/>
                                <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#periodStart').datetimepicker({
                                        format: 'YYYY-MM-DD'
                                    });
                                    $('#periodStart').on("dp.change", function (e) {
                                        redrawAllData();
                                    });
                                });
                            </script>
                        </label>
                    </div>
                    <div class="form-group">
                        <label>
                            Period do: <br/>
                            <div class='input-group input-group-sm date'>
                                <input type='text' class="form-control input-sm"
                                       id='periodEnd'
                                       name="periodEnd"
                                       oninput="redrawAllData()"/>
                                <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    $('#periodEnd').datetimepicker({
                                        format: 'YYYY-MM-DD'
                                    });
                                    $('#periodEnd').on("dp.change", function (e) {
                                        redrawAllData();
                                    });
                                });
                            </script>
                        </label>
                    </div>
                </form>
            </div>

            <div class='row'>
                <div class="col-md-2">
                    <div class="list-group" style="height: calc(100vh - 180px); overflow-y: scroll;">
                        <?php
                        foreach($viewBag['data'] as $data){?>
                            <button id="<?php echo $data['serialNum']?>"
                                    type="button" class="list-group-item"
                                    onclick="select('<?php echo $data['serialNum']?>', '<?php echo $data['display_name']?> ')">
                                <?php echo $data['display_name']?> (<?php echo $data['serialNum']?>)
                            </button>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <script>

                    var lineChart = null;
                    var masine = {};
                    var brojSelektovanih = 0;
                    var boje = [
                        'rgba(75,192,192,1)',
                        'rgba(225,85,84,1)',
                        'rgba(225,188,47,1)',
                        'rgba(59,178,115,1)',
                        'rgba(119,104,174,1)'];

                    var podeok = 1;

                    function setPodeok(p) {
                        if (p === podeok) return;
                        podeok = p;
//                        $('#po-danu').removeClass('active');
                        $('#po-danu').removeClass('btn-primary');
                        $('#po-danu').removeClass('btn-default');
//                        $('#po-mesecu').removeClass('active');
                        $('#po-mesecu').removeClass('btn-primary');
                        $('#po-mesecu').removeClass('btn-default');
                        if (p === 0) {
//                            $('#po-danu').addClass('active');
                            $('#po-danu').addClass('btn-primary');
                            $('#po-mesecu').addClass('btn-default')
                        } else if (p === 1) {
//                            $('#po-mesecu').addClass('active');
                            $('#po-mesecu').addClass('btn-primary');
                            $('#po-danu').addClass('btn-default');

                        }
                        redrawAllData();
                    }

                    function redrawAllData() {
                        $.each(masine, function(key, value){
                            getData(key);
                        });
                        drawChart();
                    }


                    function select(serialNumber, name) {
                        var id = '#' + serialNumber;
                        if (masine[serialNumber]) {
                            $(id).removeClass('active');
                            boje.push(masine[serialNumber].color);
                            delete masine[serialNumber];
                            --brojSelektovanih;
                        } else {
                            if (brojSelektovanih > 4) {
                                return;
                            }
                            ++brojSelektovanih;
                            $(id).addClass('active');
                            masine[serialNumber] = {
                                color: boje.pop(),
                                name: name
                            };
                            getData(serialNumber);
                        }
                        drawChart();
                    }

                    function getData(serialNumber) {
                        var url = '/Home/getBy';
                        if (podeok === 0) {
                            url += 'Day';
                        } else if (podeok === 1) {
                            url += 'Month';
                        }
                        $.ajax(url,{
                            method: 'POST',
                            async: false,
                            data: {
                                serialNum: serialNumber,
                                periodStart: document.getElementById('periodStart').value,
                                periodEnd: document.getElementById('periodEnd').value
                            }
                        }).done(function(data) {
                            masine[serialNumber].data = JSON.parse(data);
                        });
                    }

                    function drawChart(){
//                        resetCanvas();
//                        if(podeok === 0) {
//                            chartOptions.options.scales.xAxes[0].time = {unit: 'day'};
//                        } else if (podeok === 1) {
//                            chartOptions.options.scales.xAxes[0].time = {unit: 'month'};
//                        }
                        var data = {datasets: []};
                        $.each(masine, function(key, value){
                            var mData = mapData();
                            data.datasets.push({
                                label: masine[key].name + '(' + key + ')',
                                data: mData,
                                strokeColor: masine[key].color,
                                borderColor: masine[key].color,
                                backgroundColor: masine[key].color.replace(',1)', ',0.25)'),
                                pointBorderColor: masine[key].color,
                                pointBorderWidth: 1,
                                pointHoverBackgroundColor: masine[key].color
                            });
                            function mapData() {
                                var retArr = [];
                                for (var i = 0; i < masine[key].data.length; ++i) {
                                    retArr.push({
                                        x: moment.utc(masine[key].data[i].datetime, 'YYYY-MM-DD'),
                                        y: masine[key].data[i].total
                                    });
                                }
                                return retArr;
                            }
                        });

                        resetCanvas();
                        var ctx = document.getElementById("lineChart").getContext('2d');
                        var chartOpt = {
                            responsive: true,
                                hoverMode: 'single', // should always use single for a scatter chart
                                scales: {
                                xAxes: [{
                                    type: 'time',
                                    time: {
                                        tooltipFormat: 'YYYY-MM-DD'
                                    }
                                }],
                                    yAxes: [{
                                    gridLines: {
                                        zeroLineColor: "rgba(0,0,0,0.85)"
                                    }}]
                            }
                        };
                        if(podeok === 1) {
                            chartOpt.scales.xAxes[0].time.unit = 'month';
                        }
                        lineChart = Chart.Scatter(ctx, {
                            data: data,
                            options: chartOpt
                        });

                        function resetCanvas() {
                            $('#lineChart').remove(); // this is my <canvas> element
                            $('#chart-container').append('<canvas id="lineChart"></canvas>');
                        }
                    }
                </script>


                <div class="col-md-10">
                    <div id="chart-container" style="width: 80vw">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php

        $this->footer();
    }
}
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

                <div class="col-md-2">
                    <div class="list-group">
                        <div class="btn-group" role="group" aria-label="...">
                            <button id="po-danu" type="button" class="btn btn-default" onclick="setPodeok(0)">Po danu</button>
                            <button id="po-mesecu" type="button" class="btn btn-default active" onclick="setPodeok(1)">Po mesecu</button>
                        </div>



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

                    Chart.defaults.global.responsive = true;
                    Chart.defaults.global.animation = false;

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
                        $('#po-danu').removeClass('active');
                        $('#po-mesecu').removeClass('active');
                        if (p === 0) {
                            $('#po-danu').addClass('active');
                        } else if (p === 1) {
                            $('#po-mesecu').addClass('active');
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
                                serialNum: serialNumber
                            }
                        }).done(function(data) {
                            masine[serialNumber].data = JSON.parse(data);
                            console.log(masine[serialNumber]);
                        });
                    }

                    function drawChart(){
//                        resetCanvas();
//                        if(podeok === 0) {
//                            chartOptions.options.scales.xAxes[0].time = {unit: 'day'};
//                        } else if (podeok === 1) {
//                            chartOptions.options.scales.xAxes[0].time = {unit: 'month'};
//                        }
                        var data = [];
                        $.each(masine, function(key, value){
                            var mData = mapData();
                            data.push({
                                label: masine[key].name + '(' + key + ')',
                                data: mData,
                                strokeColor: masine[key].color,
                                borderColor: masine[key].color,
                                pointBorderColor: masine[key].color,
                                pointHoverBackgroundColor: masine[key].color,
//                                backgroundColor: masine[key].color
                            });
                            function mapData() {
                                var retArr = [];
                                for (var i = 0; i < masine[key].data.length; ++i) {
                                    retArr.push({
                                        x: moment(masine[key].data[i].datetime).toDate(),
                                        y:masine[key].data[i].total
                                    });
                                }
                                return retArr;
                            }
                        });

//                        resetCanvas();
                        var ctx = $("#lineChart").get(0).getContext('2d');
                        console.log(ctx);
                        lineChart = new Chart(ctx).Scatter(data, {
                            bezierCurve: true,
                            showTooltips: true,
                            scaleShowHorizontalLines: true,
                            scaleShowLabels: true,
                            scaleType: "date",
                            scaleDateFormat: 'yyyy-mm-dd'
                        });

                        function resetCanvas() {
                            $('#lineChart').remove(); // this is my <canvas> element
                            $('#chart-container').append('<canvas id="lineChart"></canvas>');
                        }
                    }
                </script>


                <div class="col-md-10">
                    <div id="chart-container">
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
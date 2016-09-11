<?php
/**
 * Created by PhpStorm.
 * User: milan
 * Date: 29.7.16.
 * Time: 11.47
 */

namespace BetInnovation\Core;


class TableGenerator
{

    public function __construct($headers, $data)
    {
        ?>
        <div id="loading-table" style="text-align: center; height: calc(100vh - 257px); line-height: calc(100vh - 257px);font-size: 30px">
            <i class="fa fa-cog fa-spin fa-fw"></i><span>Loading</span>
        </div>
        <div class="hidden" id="table-container">
            <table id="table" class="table table-hover table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <?php
                    foreach ($headers as $header) {
                        ?>
                        <?php //if($header['native_type']=='numeric') echo "data-type='num'";?>
                        <th>
                            <?php echo $header['name'];?>
                        </th>
                        <?php
                    }
                    ?>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data as $row) {
                    echo "<tr>";
                    foreach ($headers as $header) {
                        ?>
                        <td class="<?php echo $header['native_type']; ?>">
                            <?php
                            if($header['native_type']==='timestamptz') {
                                if($row[$header['name']]){
//                                    $date = new \DateTime($row[$header['name']]);
//                                    echo str_replace(' 00:00:00', '', $date->format("Y-m-d H:i:s"));
                                    echo $row[$header['name']];
                                }

                            }
                            else if($header['native_type']==='numeric') {
                                echo number_format($row[$header['name']], 2, ',', '.');
                            }
                            else
                                echo $row[$header['name']]; ?>
                        </td>
                        <?php
                    }
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
        <!--        scrollY: 400,-->
        <!--        paging: false,-->
        <!--        pageLength: 50,-->
                <script>
                    $(document).ready(function () {
                        $('#table').DataTable( {
                            scrollY: '55vh',
                            pageLength: 50,
                            order: [],
                            processing: true,
                            "searching": false,
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Serbian.json",
                                "thousands": ".",
                                decimal: ','
                            },
                            colReorder: true
                        });

                        $('#table').on( 'draw.dt', function () {
                            $('#loading-table').addClass('hidden');
                            $('#table-container').removeClass('hidden');
                        } );
                    })
                </script>
        <?php
    }
}
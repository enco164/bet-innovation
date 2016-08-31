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
    private function formatDate($d) {
        return str_replace(' 00:00:00', '', $d);
    }

    public function __construct($headers, $data)
    {
        ?>
        <div class="">
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
                                if($row[$header['name']])
                                    echo $this->formatDate(date("d.M.Y H:i:s", strtotime($row[$header['name']])));
                            }
                            else if($header['native_type']==='numeric') {
                                //echo $row[$header['name']];
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
            $('#table').DataTable( {
                scrollY: '55vh',
                pageLength: 50,
                processing: true,
                "searching": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Serbian.json",
                    "thousands": ".",
                    decimal: ','
                },
                colReorder: true
            });
        </script>
        <?php
    }
}
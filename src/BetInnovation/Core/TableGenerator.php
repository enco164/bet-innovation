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
                        <th>
                            <?php echo $header['name']; ?>
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
                                    echo $this->formatDate(date("d.m.Y H:i:s", strtotime($row[$header['name']])));
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
        <script>
            $(document).ready(function() {
                $('#table').DataTable();
            } );
        </script>
        <?php
    }
}
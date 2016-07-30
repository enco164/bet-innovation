<?php
/**
 * Created by PhpStorm.
 * User: milan
 * Date: 29.7.16.
 * Time: 19.06
 */

namespace BetInnovation\Core;


class FilterGenerator
{

    /**
     * FilterGenerator constructor.
     */
    public function __construct($filterArray)
    {
        foreach ($filterArray as $filter){?>
            <div class="form-group">
                <label>
                    <?php
                    echo $filter['label'];

                    switch ($filter['type']) {
                        case 'select':
                            ?>
                            <select name='<?php echo $filter['name']; ?>' class='form-control' value="<?php if(isset($_POST[$filter['name']]))
                            echo $_POST[$filter['name']];
                            ?>">
                                <option value="">--Izaberi--</option>
                                <?php
                                    foreach ($filter['values'] as $value) {
                                        ?>
                                        <option value='<?php echo $value[0];?>'
                                            <?php if(isset($_POST[$filter['name']]) && $_POST[$filter['name']]===$value[0]) echo 'selected' ?>>
                                            <?php echo $value[1];?>
                                        </option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <?php
                            break;
                        case 'date': {
                            ?>
                        <div class='input-group date' id='<?php echo $filter['name']; ?>'>
                            <input type='text' class="form-control"
                                   name="<?php echo $filter['name']; ?>"
                                   <?php if(isset($_POST[$filter['name']])) {
                                       echo "value=\"";
                                       echo $_POST[$filter['name']];
                                       echo "\"";
                                   }?>
                            />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#<?php echo $filter['name']; ?>').datetimepicker({
                                    format: 'DD.MM.YYYY'
                                });
                            });
                        </script>

                            <?php
                        }
                        break;
                            case 'time': {
                            ?>
                        <div class='input-group date' id='<?php echo $filter['name']; ?>'>
                            <input type='text' class="form-control"
                                   name="<?php echo $filter['name']; ?>"
                                <?php if(isset($_POST[$filter['name']])) {
                                    echo "value=\"";
                                    echo $_POST[$filter['name']];
                                    echo "\"";
                                }?>
                            />
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                        </div>
                        <script type="text/javascript">
                            $(function () {
                                $('#<?php echo $filter['name']; ?>').datetimepicker({
                                    format: 'H:mm'
                                });
                            });
                        </script>

                        <?php
                    }
                    }
                    ?>
                </label>
            </div>
            <?php
        }
    }
}
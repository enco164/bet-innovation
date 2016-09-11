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
        foreach ($filterArray as $filter){
            ?>
            <div class="form-group">
                <label>

                    <?php
                    echo "<input type='checkbox' name=" . $filter['name'] . " id=" . $filter['name'] . "Box>";

                    echo $filter['label'] . "<br/>";

                    switch ($filter['type']) {
                        case 'select':
                            ?>
                            <select name='<?php echo $filter['name']; ?>' class='form-control input-sm' value="<?php if(isset($_POST[$filter['name']]))
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
                        <div class='input-group input-group-sm date' id='<?php echo $filter['name']; ?>'>
                            <input type='text' class="form-control input-sm"
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
                                    format: 'YYYY-MM-DD'
                                });
                            });
                        </script>

                            <?php
                        }
                        break;
                            case 'time': {
                            ?>
                        <div class='input-group input-group-sm date' id='<?php echo $filter['name']; ?>'>
                            <input type='text' class="form-control input-sm"
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
        ?>

        <script>
            function checkboxChanged($checkboxId) {

            }

            function resetFields($submitFlag) {
                var formElement = document.getElementById("filtersForm");
                var elements = formElement.elements;

                for(i=0; i<elements.length; i++) {

                    field_type = elements[i].type.toLowerCase();

                    switch(field_type) {

                        case "text":
                        case "password":
                        case "textarea":
                        case "hidden":
                            elements[i].value = "";
                            break;

                        case "radio":
                        case "checkbox":
                            if (elements[i].checked) {
                                elements[i].checked = false;
                            }
                            break;

                        case "select-one":
                        case "select-multi":
                            elements[i].selectedIndex = -1;
                            break;

                        default:
                            break;
                    }
                }
                if($submitFlag)
                    document.getElementById("filtersForm").submit();
            }
        </script>

        <div class='form-group' style='margin-top: 15px'>
            <input type="button" class='btn btn-danger btn-sm' onclick="resetFields(false)" value="Reset">
            <input type='button' class='btn btn-primary btn-sm' onclick="resetFields(true)" value="Isključi filtere">
            <input type='submit' class='btn btn-primary btn-sm' value='Prikaži'>
        </div>
        <?php
    }
}
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
                    echo "<input type='checkbox' name='" . $filter['name'] . "Box' ";
                    if(isset($_POST[$filter['name'] . "Box"])) {
                        echo "checked=\"checked\" ";
                    }
                    echo " id='" . $filter['name'] . "Box' style='margin-right: 8px'>";

                    echo $filter['label'] . "<br/></label><br>";

                    switch ($filter['type']) {
                        case 'select':
                            ?>
                            <select id='<?php echo $filter['name']; ?>'
                                    name='<?php echo $filter['name']; ?>'
                                    class='form-control input-sm'
                                    value="<?php if(isset($_POST[$filter['name']]))
                                        echo $_POST[$filter['name']];
                                    ?>" disabled="disabled">
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
                        <div class='input-group input-group-sm date'>
                            <input id="<?php echo $filter['name']; ?>" type='text' class="form-control input-sm"
                                   name="<?php echo $filter['name']; ?>"
                                   <?php if(isset($_POST[$filter['name']])) {
                                       echo "value=\"";
                                       echo $_POST[$filter['name']];
                                       echo "\"";
                                   }?>
                                   disabled="disabled"/>
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
                        <div class='input-group input-group-sm date'>
                            <input id="<?php echo $filter['name']; ?>" type='text' class="form-control input-sm"
                                   name="<?php echo $filter['name']; ?>"
                                <?php if(isset($_POST[$filter['name']])) {
                                    echo "value=\"";
                                    echo $_POST[$filter['name']];
                                    echo "\"";
                                }?> disabled="disabled"
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

            $(document).ready(function() {


                $( "form input:checkbox").each(function(index, chbox) {
                    var id = $(chbox).attr('id');
                    id = '#' + id.substr(0, id.length - 3);

                    if ($(chbox).is(':checked')) {
                        $(id).prop('disabled', false);
                    } else {
                        checkBoxDateTimeLogic(id, true);
                    }

                    $(chbox).change(function() {
                        if ($(this).is(':checked')) {
                            $(id).prop('disabled', false);
                            checkBoxDateTimeLogic(id, false);

                        } else {
                            $(id).prop('disabled', true);
                            checkBoxDateTimeLogic(id, true);
                        }
                    });

                    function checkBoxDateTimeLogic(id, disabled) {
                        if (id == '#datetimeFromDate') {
                            $('#datetimeFromTimeBox').prop('disabled', disabled);
                        }

                        if (id == '#datetimeToDate') {
                            $('#datetimeToTimeBox').prop('disabled', disabled);
                        }

                        if (disabled) {
                            $('#datetimeToTimeBox').prop('checked', false);
                            $('#datetimeFromTimeBox').prop('checked', false);
                            $('#datetimeToTime').prop('disabled', true);
                            $('#datetimeFromTime').prop('disabled', true);
                        }
                    }
                });
            });

            function checkboxChanged($checkboxId) {

            }

            function clearElement(element) {
                var field_type = element.type.toLowerCase();
                switch (field_type) {

                    case "text":
                    case "password":
                    case "textarea":
                    case "hidden":
                        element.value = "";
                        break;

                    case "radio":
                    case "checkbox":
                        if (element.checked) {
                            element.checked = false;
                        }
                        break;

                    case "select-one":
                    case "select-multi":
                        element.selectedIndex = -1;
                        break;

                    default:
                        break;
                }
            }
            function resetFields($submitFlag) {
                var formElement = document.getElementById("filtersForm");
                var elements = formElement.elements;

                for(var i=0; i < elements.length; i++) {
                    clearElement(elements[i]);
                }
                if($submitFlag)
                    document.getElementById("filtersForm").submit();
            }
            
            function submitForm() {
                $( "form input:checkbox").each(function(index, chbox) {
                    if (!$(chbox).is(':checked')) {
                        var id = $(chbox).attr('id');
                        id = id.substr(0, id.length - 3);
                        clearElement( document.getElementById(id));
                    }
                });
                document.getElementById("filtersForm").submit();
            }
        </script>

        <div class='form-group' style='margin-top: 27px'>
            <input type="button" class='btn btn-danger btn-sm' onclick="resetFields(false)" value="Reset">
            <input type='button' class='btn btn-primary btn-sm' onclick="resetFields(true)" value="Isključi filtere">
            <input type='button' class='btn btn-primary btn-sm' onclick="submitForm()" value='Prikaži'>
        </div>
        <?php
    }
}
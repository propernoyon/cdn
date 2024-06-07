 <?php
function toriqul_datalist($datalist_id, $hidden_field, $sql, $value = '', $required = '') {
    $rdd = mt_rand(1, 9999);
    $input_id = $hidden_field . $rdd;
    $showval = '';

    if ($value != '') {
        // Extracting columns from the SQL query
        $matches = [];
        preg_match('/\bselect\s+(.*?)\bfrom\s+(\w+)/i', $sql, $matches);

        if (!empty($matches)) {
            $selectColumns = trim($matches[1]);
            $afterSelect = trim($matches[2]);

            $columns = explode(',', $selectColumns);
            $col1 = trim($columns[0]);
            $col2 = trim($columns[1]);
            $table = $afterSelect;

            $vc = "SELECT $col2 FROM $table WHERE $col1='" . mysql_real_escape_string($value) . "'";
            $vcq = mysql_query($vc);
            if ($vcq) {
                $vcData = mysql_fetch_array($vcq);
                $showval = $vcData[0];
            } else {
                echo "Error: " . mysql_error();
            }
        } else {
            echo "Not Found";
        }
    }

 
    echo '<input list="'.$datalist_id.'" id="'.$input_id.'" name="'.$input_id.'" autocomplete="off" type="text" value="'.$showval.'" '.($required ? 'required' : '').'>';
    echo '<datalist id="'.$datalist_id.'">';
    
    $res = mysql_query($sql);
    if ($res) {
        while ($data = mysql_fetch_row($res)) {
            echo '<option value="'.$data[1].'" data-value="'.$data[0].'"></option>';
        }
    } else {
        echo "Error: " . mysql_error();
    }
    echo '</datalist>';

   
    echo '<input type="hidden" name="'.$hidden_field.'" id="'.$hidden_field.'" value="'.$value.'" '.($required ? 'required' : '').'>';

    echo '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const setDataValue = function(inputId, hiddenId, dataListId) {
            const inputElement = document.getElementById(inputId);
            const hiddenInputElement = document.getElementById(hiddenId);
            const dataList = document.getElementById(dataListId);

            const checkMatch = function() {
                const options = dataList.options;
                let found = false;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === inputElement.value) {
                        const dataValue = options[i].getAttribute("data-value");
                        hiddenInputElement.value = dataValue;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    hiddenInputElement.value = "";
                    inputElement.value = "";
                    inputElement.placeholder = "Not Found";
                }
            };

            inputElement.addEventListener("input", function() {
                const options = dataList.options;
                let found = false;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === inputElement.value) {
                        const dataValue = options[i].getAttribute("data-value");
                        hiddenInputElement.value = dataValue;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    hiddenInputElement.value = "";
                }
            });

            inputElement.addEventListener("blur", checkMatch);
        };

        setDataValue("'.$input_id.'", "'.$hidden_field.'", "'.$datalist_id.'");
    });
    </script>';
}
echo 111;
?>

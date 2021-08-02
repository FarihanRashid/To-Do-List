<?php
require_once("./db_details.php");
$select_query = "SELECT * FROM $table_name";
$result_from_db = mysqli_query($db_connect, $select_query);

if (isset($_POST['update_form_btn'])) {
    if ($_POST['update_form_btn'] != "") {
        $i = 0;
        foreach ($result_from_db as $task_detail) {
            $i++;
            if (isset($_POST["status$i"])) {
                $id = $task_detail['id'];
                $update_query = "UPDATE $table_name SET status='done' WHERE id='$id'";
                mysqli_query($db_connect, $update_query);
            } else {
                $id = $task_detail['id'];
                $update_query = "UPDATE $table_name SET status='undone' WHERE id='$id'";
                mysqli_query($db_connect, $update_query);
            }
        }
    }
    else{
        echo "Error in Link";
    }
}
header("location: index.php");
?>
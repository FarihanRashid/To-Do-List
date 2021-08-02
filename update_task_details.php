<?php
require_once("./db_details.php");

if (isset($_GET['due_date']) && isset($_GET['task_name']) && isset($_GET['id'])) {
    if ($_GET['due_date'] != "" && $_GET['task_name'] != "" && $_GET['id'] != "") {
        $id = $_GET['id'];
        $date = $_GET['due_date'];
        $task_name = $_GET['task_name'];
        $date_short = strtotime($_GET['due_date']);
        $year = date("Y", $date_short);
        $month = date("F", $date_short);
        $day = date("d", $date_short);

        $update_query = "UPDATE $table_name SET task_name='$task_name', date= '$date', year= $year , month= '$month', day= '$day'  WHERE id='$id'";
        mysqli_query($db_connect, $update_query);
    } else {
        echo "Error in Link";
    }
}
?>
<script>
    window.close();
</script>
<?php
require_once("./db_details.php");
$update_query = "UPDATE $table_name SET status='undone'";
mysqli_query($db_connect, $update_query);
header("location: index.php");

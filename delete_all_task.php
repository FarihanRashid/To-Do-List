<?php
require_once("./db_details.php");
$id = $_GET['id'];
$delete_query = "DELETE FROM $table_name";
mysqli_query($db_connect, $delete_query);
header("location: index.php");

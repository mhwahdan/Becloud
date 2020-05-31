<?php
include 'conn_s.php';
session_start();
$userid = $_SESSION["user"][0];
$ntask = $_SESSION["user"][11] + 1;
$userrating = ($_SESSION["user"][9] + $_GET["p"])/$ntask;
$tid = $_GET["q"];
$query ="SELECT * FROM tickets WHERE ticket_id = '$tid'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_row($result);
$rid = $row[2];
$query ="UPDATE users set rating = '$userrating',tasks_n = '$ntask' where user_id ='$rid'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$query ="DELETE FROM tickets WHERE ticket_id = '$tid'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
?>

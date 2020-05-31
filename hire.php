<?php
include 'conn_s.php';
session_start();
$userid = $_SESSION["user"][0];
$cmid = $_GET["p"];
$did = $_GET["x"];
$name = $_GET["q"];
$description = $_GET["r"];
$salary = $_GET["s"];
$query = "SELECT * FROM `users` WHERE name='$name'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$uid = $row['user_id'];
$query = "INSERT INTO hiring (sender_id,user_id,company_id,department_id,salary,description,when_time,level) VALUES ('$userid','$uid','$cmid','$did','$salary','$description',NOW(),1)";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
echo "hiring request sent succesfully !!!";
?>

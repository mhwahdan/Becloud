<?php
include 'conn_s.php';
session_start();
$uid = $_SESSION["user"][0];
$uname = $_SESSION["user"][1];
$receiver = $_GET['q'];
$body = $_GET['p'];
$subject = $_GET['r'];
echo $body;
$query ="SELECT * FROM users where name ='$receiver'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_row($result);
$rid = $row[0];
$rname = $row[1];
$query = "INSERT INTO message (sender_id, receiver_name,subject, sender_name, user_id, body, time_t) VALUES ('$uid','$rname','$subject','$uname', '$rid', '$body', NOW());";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
 ?>

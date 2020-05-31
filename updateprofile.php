<?php
session_start();
$id = $_SESSION["user"][0];
$email = $_GET["b"];
$profession = $_GET["c"];
$mobile = $_GET["d"];
include 'conn_s.php';
if(isset($_GET["e"]))
{
  $bio = $_GET["e"];
  $query = "UPDATE users set email = '$email' ,profession = '$profession' ,mobile = '$mobile' ,bio = '$bio' WHERE user_id = '$id'";
  $_SESSION["user"][12] = $bio;
}
else
  $query = "UPDATE users set email = '$email' ,profession = '$profession' ,mobile = '$mobile' WHERE user_id = '$id'";

  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $email = $_SESSION["user"][2];
  $profession = $_SESSION["user"][4];
  $mobile = $_SESSION["user"][5];
 ?>

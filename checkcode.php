<?php
session_start();
$code = $_SESSION["code"];
$id = $_SESSION["registrationid"];
$attempt = sha1($_GET["q"]);
if($attempt == $code)
{
  include 'conn_s.php';
  $query = "UPDATE users set isactive = true WHERE email = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $_SESSION["code"] = "";
  $_SESSION["registrationid"] = "";
  echo "true";
}
else
  echo "false";
 ?>

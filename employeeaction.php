<?php
include 'conn_s.php';
$name = $_GET["q"];
$cmid = $_GET["p"];
$value = $_GET["r"];
$department_p = $_GET["x"];
$department_s = $_GET["s"];
$query = "SELECT * FROM users WHERE name = '$name'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_row($result);
$uid = $row[0];
if ($value == 0)
{
  $query = "UPDATE department set head_id = '$uid' WHERE department_id = '$department_s'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif($value == 1)
{

} elseif ($value == 2)
{
  $query = "UPDATE department set head_id = 0 WHERE department_id = '$department_s'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $query = "UPDATE contracts set department_id = '$department_p' WHERE user_id = '$uid' AND company_id = '$cmid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
} elseif ($value == 3) {
  // code...
}
 ?>

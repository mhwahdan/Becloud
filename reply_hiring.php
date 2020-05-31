<?php
include 'conn_s.php';
$value = $_GET['p'];
$id = $_GET['q'];
if ($value == 0 ) {
  $query = "UPDATE hiring SET state = 1 WHERE hiring_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif ($value == 1) {
  $query = "UPDATE hiring SET state = 2 WHERE hiring_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif ($value == 2)
{
  $query = "SELECT * FROM hiring WHERE hiring_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_row($result);
  $uid = $row[1];
  $cid = $row[3];
  $did = $row[9];
  $salary = $row[5];
  $query = "INSERT INTO contracts (user_id,company_id,department_id,salary,level) VALUES ( '$uid','$cid','$did',salary,1)";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $query = "DELETE FROM hiring WHERE hiring_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif ($value == 3) {
  $query = "DELETE FROM hiring WHERE hiring_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
 ?>

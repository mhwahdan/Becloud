<?php
include 'conn_s.php';
$value = $_GET['q'];
$id = $_GET['p'];
if ($value == 1 ) {
  $query = "UPDATE ownership SET status = 1 WHERE ownership_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $query = "SELECT * FROM ownership WHERE ownership_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
  $cid = $row[3];
  $query = "SELECT * FROM ownership WHERE company_id = '$cid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  if(mysqli_num_rows($result) == 0){
    $query1 = "UPDATE companies SET isapproved = 1 WHERE company_id = '$cid'";
    $result1 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  }
} else if ($value == 0) {
  $query = "DELETE FROM ownership WHERE company_id = '$cid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $query = "DELETE FROM companies WHERE company_id = '$cid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
 ?>

<?php
session_start();
include '../../conn_s.php';
$email = $_SESSION['name'];
$company = $_SESSION['company_name'];
$query = "SELECT * FROM companies WHERE name = '$company'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$id = $row['company_id'];
$query = "SELECT DISTINCT department FROM users_companies WHERE company_id = '$id' AND department != 'NULL'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result))
      echo '<input class="nav-link" style="width:100%;" name="submit" value ="'.$row['department'].'" type="submit" />';
    }
 else {
   echo '<label>no companies created yet </label>';
}
 ?>

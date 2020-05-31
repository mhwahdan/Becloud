<?php
session_start();
include '../../conn_s.php';
$useremail = $_SESSION["name"];
$query = "SELECT * FROM users WHERE email = '$useremail' ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$cip = $row['user_id'];
$query = "SELECT  DISTINCT company_id FROM users_companies WHERE user_id = '$cip' ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  $cip = $row['company_id'];
  $query = "SELECT DISTINCT user_id FROM users_companies WHERE company_id = '$cip'";
  $result1 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while($row1 = mysqli_fetch_assoc($result1)) {
    $uip = $row1['user_id'];
    $query = "SELECT * FROM users WHERE user_id = '$uip'";
    $result2 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
    while($row2 = mysqli_fetch_assoc($result2)) {
    $pp = sha1($row2['email']);
    echo "<tr>";
    echo '<td><img src = "../../pp/'.$pp.'" style="width:75px;height:75px;"></img></td>';
    echo '<td>'.$row2['name'].'</td>';
    echo '<td>0'.$row2['mobile'].'</td>';
    echo '<td>'.$row2['email'].'</td>';
    echo '<td>'.$row2['profession'].'</td>';
    echo "</tr>";
}
}
}
 ?>

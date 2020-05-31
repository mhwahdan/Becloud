<?php
session_start();
include '../../conn_s.php';
$company = $_SESSION['company_name'];
$query = "SELECT * FROM companies WHERE name = '$company' ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_row($result);
$companyid = $row[0];
$department = $_POST['submit'];
$query = "SELECT * FROM users_companies WHERE company_id = '$companyid' AND department = '$department' ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  $uip = $row['user_id'];
  $query = "SELECT * FROM users WHERE user_id = '$uip'";
  $result1 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while($row1 = mysqli_fetch_assoc($result1)) {
  $pp = sha1($row1['email']);
  echo "<tr>";
  echo '<td><img src = "../../pp/'.$pp.'" style="width:75px;height:75px;"></img></td>';
  echo '<td>'.$row1['name'].'</td>';
  echo '<td>0'.$row1['mobile'].'</td>';
  echo '<td>'.$row1['email'].'</td>';
  echo '<td><button class="nav-link" style="width:100%;" name="submit" value ="'.$row['user_id'].'" type="submit">Send task</button></td>';
  echo '<td><button class="nav-link" style="width:100%;" name="submit" value ="'.$row['user_id'].'" type="submit">Terminate</button></td>';
  echo "</tr>";
}
}
 ?>

<?php
session_start();
$userid = $_SESSION["user"][0];
include 'conn_s.php';
$search = $_GET["q"];
$uuid = $_GET["p"];
$ss = $_GET["s"];
  $query = "SELECT  DISTINCT company_id FROM contracts WHERE user_id = '$userid' ";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result)) {
    $cip = $row['company_id'];
    $query = "SELECT * FROM contracts WHERE company_id = '$cip'";
    $result1 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
    while($row1 = mysqli_fetch_assoc($result1)) {
      $uip = $row1['user_id'];
      if ($search != "")
      $query = "SELECT * FROM users WHERE user_id = '$uip' AND ( name LIKE '%$search%' OR  mobile LIKE '%$search%' OR  email LIKE '%$search%')";
      else
      $query = "SELECT * FROM users WHERE user_id = '$uip'";
      $result2 = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
      while($row2 = mysqli_fetch_assoc($result2)) {
        if($ss != "contacts")
        $dd = "document.getElementById('".$uuid."').value = '".$row2['name']."';document.getElementById('$ss').innerHTML='';document.getElementById('$ss').style.border='0px';";
        else
        $dd = "document.getElementById('".$uuid."').value = '".$row2['name']."';";
      echo '<div class="row" onclick="'.$dd.';" style="margin:auto;" >';
      echo '<label style="margin-left:5%;margin-right:5%;">Name: <span>'.$row2['name'].'</span><br>Email: '.$row2["email"].'<br>Profession: '.$row2["profession"].'</label>';
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
        }
      }
  }
 ?>

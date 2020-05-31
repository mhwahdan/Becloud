<?php
session_start();
$userid = $_SESSION["user"][0];
$username = $_SESSION["user"][1];
include 'conn_s.php';
$query = "SELECT * FROM message WHERE user_id = '$userid' OR sender_id = '$userid' ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  echo "<div class='row float-center' style='margin-top:5%;margin:auto'>";
  echo "<button onclick='viewmsg();' style='margin:auto;margin-top:5%;' class='btn btn-secondry-outline'><img src='refresh.svg' style='width:8vh;height:8vh;'/></button>";
  echo "</div>";
  if($row["user_id"] == $userid){
    echo "<div style='margin:5%;' class='row alert alert-info alert-dismissible fade show' role='alert'>";
    echo '<label>From: '.$row["sender_name"].'<br>To: '.$username.'<br>Subject: '.$row["subject"].'<br><br>'.$row["body"].'</label>';
  }
  else
  {
    echo "<div style='margin:5%;' class='row alert alert-success alert-dismissible fade show' role='alert'>";
    echo '<label>From: '.$username.'<br>To: '.$row["receiver_name"].'<br>Subject: '.$row["subject"].'<br><br>'.$row["body"].'</label>';
  }
  echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">  <span aria-hidden="true">&times;</span></button>';

  echo "</div>";
  echo '<div class="dropdown-divider"></div>';

}
 ?>

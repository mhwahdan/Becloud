<?php
session_start();
include 'conn_s.php';
$index  = $_SESSION["user"][0];
//view approved hire request
$query = "SELECT * FROM hiring WHERE sender_id = '$index' AND state = 1 ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while ($hire = mysqli_fetch_row($result)){
  $uid = $hire[1];
  $query1 = "SELECT * FROM users WHERE user_id = '$uid'";
  $result1 = mysqli_query($conn, $query1) or die("connection falied".mysqli_error($conn));
  $user = mysqli_fetch_row($result1);
  $companyid = $hire[3];
  $query = "SELECT * FROM companies WHERE company_id = '$companyid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $c = mysqli_fetch_row($result);
  echo '<div class="row" id="hire'.$hire[0].'">';
  echo '<div class="col-2">';
  echo '<img style="border-radius:50%;width:25vh;height:25vh;padding-right:2vh;" src="/pp/'.sha1($c[1]).'.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-5">';
  echo '<h5>you hiring request has been approved </h5>';
      echo '<label>employee name: '.$user[1].'</label>';
      echo '<br><label>company name: '.$c[1].'</label>';
      echo "</div>";
      echo '<div class="col-5">';
      echo '<label>Job description: '.$hire[6].'</label>';
      echo '<br><label>Jobs alary: '.$hire[5].' EG</label>';
      echo '<div class="row" style="margin-bottom:2%;margin-top:30%;">';
      echo '<button class="btn btn-dark" onclick="reply(2,'.$hire[0].',1);" style="margin-left:2%;">Hire</button>';
      echo '<button class="btn btn-dark" onclick="reply(3,'.$hire[0].',1);" style="margin-left:5%">Refuse hiring</button>';
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
  }
//view hiring request
$query = "SELECT * FROM hiring WHERE user_id = '$index' AND state = 0 ";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while ($hire = mysqli_fetch_row($result)){
  $companyid = $hire[3];
  $query = "SELECT * FROM companies WHERE company_id = '$companyid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $c = mysqli_fetch_row($result);
  echo '<div class="row" id="hire'.$hire[0].'">';
  echo '<div class="col-2">';
  echo '<img style="border-radius:50%;width:25vh;height:25vh;padding-right:2vh;" src="/pp/'.sha1($c[1]).'.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-5">';
  echo '<h5>you have a new hiring request </h5>';
      echo '<br><label>company name: '.$c[1].'</label>';
      echo '<br><label>company email: '.$c[2].'</label>';
      echo '<br><label>company mobile: '.$c[3].'</label>';
      echo '<br><label>company field: '.$c[4].'</label>';
      echo '<br><label>company website:<a href="'.$c[5].'"> '.$c[5].'</a></label>';
      echo '<br><label>company creation date: '.$c[6].'</label>';
      echo "</div>";
      echo '<div class="col-5">';
      echo '<label>Job description: '.$hire[6].'</label>';
      echo '<br><label>Jobs alary: '.$hire[5].' EG</label>';
      echo '<div class="row" style="margin-bottom:2%;margin-top:30%;">';
      echo '<button class="btn btn-dark" onclick="reply(1,'.$hire[0].',1);" style="margin-left:2%;">Accept</button>';
      echo '<button class="btn btn-dark" onclick="reply(0,'.$hire[0].',1);" style="margin-left:50%;">refuse</button>';
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
  }
//show ownership requests
$query = "SELECT * FROM ownership WHERE user_id = '$index' AND status != 1";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while ($ownrequest = mysqli_fetch_row($result)){
  echo '<div class="row" id="own'.$ownrequest[0].'">';
  echo '<div class="col-2">';
  echo '<img style="border-radius:50%;width:25vh;height:25vh;padding-right:2vh;" src="/pp/'.sha1($ownrequest[4]).'.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-10">';
  if ($ownrequest[8] == true)
  echo '<h5>you have a new ownership request as a chair man </h5>';
  else
  echo '<h5>you have a new ownership request as a member of board of directors (stake holder) </h5>';
      echo '<br><label>From: '.$ownrequest[2].'</label>';
      echo '<br><label>company name: '.$ownrequest[4].'</label>';
      echo '<br><label>Share: '.$ownrequest[6].'%</label>';
      echo '<div class="row" style="margin-bottom:2%;">';
      echo '<button class="btn btn-dark" onclick="reply(0,'.$ownrequest[0].',0);" style="margin-left:75%;">refuse</button>';
      echo '<button class="btn btn-dark" onclick="reply(1,'.$ownrequest[0].',0);" style="margin-left:2%;">Accept</button>';
      echo "</div>";
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
}
 ?>

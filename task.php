<?php
include 'conn_s.php';
session_start();
$uid = $_SESSION["user"][0];
$uname = $_SESSION["user"][1];
$receiver = $_GET['q'];
$body = $_GET['p'];
$deadline = $_GET['r'];
$cid = $_GET['s'];
$tid = $_GET['z'];
$selection = $_GET['v'];
if($selection == 0)
{
  $query ="SELECT * FROM users where name ='$receiver'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_row($result);
  $rid = $row[0];
  $rname = $row[1];
  $query ="SELECT * FROM companies where company_id ='$cid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_row($result);
  $cname = $row[1];
  $query = "INSERT INTO tickets (company_name,company_id, sender_id, receiver_name,due_date, sender_name, receiver_id, description, time_t) VALUES ('$cname','$cid','$uid','$rname','$deadline','$uname', '$rid', '$body', NOW());";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif($selection == -2)
{
  $query ="SELECT * FROM users where name ='$receiver'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_row($result);
  $rid = $row[0];
  $rname = $row[1];
  $query ="UPDATE tickets set receiver_id = '$rid',receiver_name = '$rname',description = '$body',due_date = '$deadline' WHERE ticket_id ='$tid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif($selection == -1)
{
  $query ="DELETE FROM tickets where ticket_id ='$tid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
elseif($selection == 1)
{
  $query ="UPDATE tickets set status = 1,submit_date = NOW(),comment = '$body' where ticket_id = '$tid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
}
?>

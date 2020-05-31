<?php
include 'conn_s.php';
$department = $_GET["q"];
$admin = $_GET["p"];
$company = $_GET["r"];
$query1 = "SELECT * FROM `department` WHERE department_id = '$department' AND  company_id = '$company'";
$result1 = mysqli_query($conn, $query1) or die("connection falied".mysqli_error($conn));
$row1 = mysqli_fetch_assoc($result1);
$head_id = $row1['head_id'];
$query1 = "SELECT * FROM `contracts` WHERE department_id = '$department' AND  company_id = '$company'";
$result1 = mysqli_query($conn, $query1) or die("connection falied".mysqli_error($conn));
while($row1 = mysqli_fetch_assoc($result1)) {
  $id = $row1['user_id'];
  $query = "SELECT * FROM `users` WHERE user_id = '$id'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  $row = mysqli_fetch_assoc($result);
  $n = $row['name'];
  $cmd2 = "document.getElementById('receiver_id').disabled=true;document.getElementById('sender_id').placeholder = document.getElementById('user_name').innerHTML;document.getElementById('receiver_id').value='$n';";
  $cmd3 = "document.getElementById('ticket_sender').disabled=true;document.getElementById('ticket_sender').placeholder = document.getElementById('user_name').innerHTML;document.getElementById('ticket_receiver').value='$n';";
  if($id != $head_id)
  echo '<div  id="'.$row['name'].'" class="row" style="padding-top:2%;padding-bottom:2%;">';
  else
  echo '<div  id="'.$row['name'].'" style="background-color:lightblue;padding-top:2%;padding-bottom:2%;" class="row">';
  echo '<div class="col-2">';
  echo '<img style="border-radius:50%;width:20vh;height:20vh;" src="/pp/default.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-6">';
      echo '<a  href="../../profiles/webpages/profile.php?name='.$row['name'].'">'.$row['name'].'</a>';
      echo '<br><label>'.$row['profession'].'</label>';
      echo '<br><label>0'.$row['mobile'].'</label>';
      echo '<br><label>'.$row['email'].'</label>';
      echo '<div class="row" style="margin-bottom:2%;">';
      echo '<label style="margin-right:5%;margin-left:3vh">Rating: </label>';
      for ($i = 0; $i < $row['rating'] ; $i++)
        echo '<span class="fa fa-star " style="color:orange;"></span>';
        $command = "action('".$row['name']."'";
        for ($i = $row['rating'];$i < 5 ; $i++)
          echo '<span class="fa fa-star " ></span>';
          echo '<button class="btn btn-dark float-right" value="'.sha1($row['email']).'" onclick="view_cv(this.value);" data-toggle="modal" data-target="#fcv" style="margin-left:5%;">View CV</button>';
      echo "</div>";
      echo "</div>";
  echo '<div class="col-4">';
  echo '<div class="row">';
  echo '<button disabled class="btn btn-dark admin" onclick="'.$command.',0);">Make head of department</button>';
  echo "</div>";
  echo '<div class="row">';
  echo '<button disabled class="btn btn-dark admin head" style="margin-top:10px;" data-toggle="modal" data-target="#ticketmodal" onclick="action=0;'.$cmd3.'">Send a task</button>';
  echo "</div>";
  echo '<div class="row">';
  echo '<button class="btn btn-warning admin" style="margin-top:10px;" onclick="'.$command.',2);">promote</button>';
  echo "</div>";
  echo '<div class="row">';
  echo '<button class="btn btn-dark" style="margin-top:10px;" data-toggle="modal" onclick="'.$cmd2.'" data-target="#messagesmodal">send a message</button>';
  echo "</div>";
  echo "</div>";
  echo "</div>";
      echo '<div class="dropdown-divider"></div>';
}
 ?>

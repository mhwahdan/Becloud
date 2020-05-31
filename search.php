<?php
session_start();
$userid = $_SESSION["user"][0];;
$index = $_GET["q"];
$cmid = $_GET["p"];
$did = $_GET["s"];
include 'conn_s.php';
$query = "SELECT * FROM `users` WHERE user_id !='$userid' AND (name LIKE '%$index%' or profession LIKE '%$index%') LIMIT 3;";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  $uuid = $row['user_id'];
  $query1 = "SELECT * FROM `contracts` WHERE company_id ='$cmid' AND user_id='$uuid'";
  $result1 = mysqli_query($conn, $query1) or die("connection falied".mysqli_error($conn));
  $row1 = mysqli_fetch_assoc($result1);
  if($row1['department_id'] != $did)
  {
  if(mysqli_num_rows($result1) ==0 )
  echo '<divstyle="margin-top:10px;">';
  else
  echo '<div style="background-color:lightblue;margin-top:10px;">';
  echo '<div class="row">';
  echo '<div class="col-4">';
  echo '<img style="border-radius:50%;width:25vh;height:25vh;padding-right:2vh;" src="/pp/default.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-8">';
  $tmp = "document.getElementById('hire_form_name').value = this.innerHTML;";
  $tmp2 = "document.getElementById('Employee').innerHTML = '';";
      echo '<a href="#" onclick="'.$tmp.';'.$tmp2.';">'.$row['name'].'</a>';
      echo '<br><label id="selection">'.$row['profession'].'</label>';
      echo '<br><label>0'.$row['mobile'].'</label>';
      echo '<br><label>'.$row['email'].'</label>';
      echo "</div>";
      echo "</div>";
      echo '<div class="row" style="margin-bottom:2%;">';
      echo '<label style="margin-right:5%;margin-left:29vh;">Rating: </label>';
      for ($i = 0; $i < $row['rating'] ; $i++)
        echo '<span class="fa fa-star " style="color:orange;"></span>';
        for ($i = $row['rating'];$i < 5 ; $i++)
          echo '<span class="fa fa-star " ></span>';
      echo "</div>";
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
}
}
?>

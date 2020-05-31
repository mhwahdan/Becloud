<?php
$email = $_GET["q"];
$pp = sha1($email);
include 'conn_s.php';
$query = "SELECT * FROM `users` WHERE email = '$email'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_row($result);
echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span style="color:white;" aria-hidden="true">&times;</span>
         </button>';
      echo '<div class="container">';
      echo '<div class="container" style="margin:auto;text-align:center">';
      echo '<img data-toggle="tooltip" title="'.$row[1].'" class="img profilepicture" style="border-radius:50%;width:20vw;height:20vw;margin:auto;" src="pp/'.$pp.'.png" alt=""/>';
      echo "</div>";
      echo "<div style='text-align:center;margin:auto;font-size:25px;color:white;'>";
      echo '<label>'.$row[1].'<br>email:'.$email.'<br>profession:'.$row[4].'</label>';
      echo "</div>";
      echo '<div style="text-align:center;margin:auto;font-size:25px;">';
      for ($i = 0; $i < $row[9] ; $i++)
        echo '<span class="fa fa-star " style="color:orange;"></span>';
        for ($i = $row[9];$i < 5 ; $i++)
          echo '<span class="fa fa-star text-dark"></span>';
      echo "</div>";
      echo "</div>";

      echo '<div class="dropdown-divider"></div>
<div class="container" style="text-align:center;margin:auto;font-size:25px;color:white;">
<label>'.$row[12].'</label>
</div>
<div class="dropdown-divider"></div>
<div class="container">
<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" value="'.$pp.'" onclick="view_cv(this.value);" data-target="#fcv">view cv</button>
</div>';
?>

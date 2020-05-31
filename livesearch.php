<?php
$index = $_GET["q"];
include 'conn_s.php';
$query = "SELECT * FROM `users` WHERE name LIKE '%$index%' OR  profession LIKE '%$index%' LIMIT 5;";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  echo '<div class="row">';
  echo '<div class="col-2">';
  $cmd = "foreignprofile('".$row["email"]."');";
  echo '<img data-toggle="modal" data-target="#rprofile" onclick="'.$cmd.'" style="border-radius:50%;width:25vh;height:25vh;padding-right:2vh;" class="img" src="pp/'.sha1($row['email']).'.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-10">';
      echo '<label>'.$row['name'].'</label>';
      echo '<br><label>'.$row['profession'].'</label>';
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
          echo '<button class="btn btn-dark float-right" value="'.sha1($row['email']).'" onclick="view_cv(this.value);" data-toggle="modal" data-target="#fcv" style="margin-left:45%;">View CV</button>';
      echo "</div>";
      echo '<div class="dropdown-divider"></div>';
}
$query = "SELECT * FROM `companies` WHERE name LIKE '%$index%' OR  field LIKE '%$index%' LIMIT 5";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  echo '<div class="row">';
  echo '<div class="col-4">';
  echo '<img style="width:100px;height:100px;padding-right:5px;" src="/pp/default.png" alt="NO PP"></img>';
  echo "</div>";
  echo '<div class="col-8">';
      echo '<a  href="../../profiles/webpages/companyprofile.php?name='.$row['name'].'">'.$row['name'].'</a><br>';
      echo '<label>'.$row['field'].'</label><br>';
      echo '<label>0'.$row['mobile'].'</label><br>';
      echo '<label>Company</label><br>';
      echo "</div>";
      echo "</div>";
      echo "<br>";
}
?>

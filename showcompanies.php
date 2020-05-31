<?php
include "conn_s.php";
session_start();
$flag = 0;
$userid = $_SESSION["user"][0];
function tree($cid,$parentid,$conn,$index)
{
  $query ="SELECT * FROM department where company_id ='$cid' AND Parent ='$parentid'";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while ($row = mysqli_fetch_row($result))
  {
  echo "<li>";
  if($row[2] == $index)
    echo '<code onclick="company_s='.$row[1].';head=1;department_s='.$row[0].';showdeparmtent();" data-toggle="modal" data-target="#department" class="btn btn-primary">'.$row[3].'</code>';
  else
    echo '<code onclick="company_s='.$row[1].';head=0;parent_d='.$row[5].';department_s='.$row[0].';showdeparmtent();" data-toggle="modal" data-target="#department" class="btn btn-success">'.$row[3].'</code>';
  echo "<ul>";
  tree($cid,$row[0],$conn,$index);
  echo '<li><code data-toggle="modal" data-target="#department_info" onclick="company_s='.$row[1].';parent_d = '.$row[0].';" class="btn btn-success">Add +</code></li>';
  echo '</ul>';
  echo "</li>";
}
return 0;
}
$query1 ="SELECT * FROM contracts where user_id ='$userid'";
$result1 = mysqli_query($conn, $query1) or die("connection falied".mysqli_error($conn));

while($row1 = mysqli_fetch_row($result1))
{
  $cid = $row1[2];
  $query2 ="SELECT * FROM companies where company_id ='$cid'";
  $result2 = mysqli_query($conn, $query2) or die("connection falied".mysqli_error($conn));
  $row2 = mysqli_fetch_row($result2);
  if($flag == 0)
  {
    echo '<div class="carousel-item active">';
    $flag = 1;
  }
  else
    echo '<div class="carousel-item">';
  echo '<nav class="navbar navbar-light bg-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav-'.$row2[0].'" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav-'.$row2[0].'">';
        echo '<div class="container">';
        echo '<div class="container" style="margin:auto;text-align:center">';
        echo '<img data-toggle="tooltip" title="'.$row2[1].'" class="img profilepicture" style="border-radius:50%;width:20vw;height:20vw;margin:auto;" src="pp/'.sha1($row2[2]).'.png" alt=""/>';
        echo "</div>";
        echo "<div style='text-align:center;margin:auto;font-size:25px;color:white;'>";
        echo '<label>'.$row2[1].'<br>email:'.$row2[2].'<br>field:'.$row[4].'</label>';
        echo "</div>";
        echo "</div>";
        echo '<div class="dropdown-divider"></div>
  <div class="container" style="text-align:center;margin:auto;font-size:25px;color:white;">
  <label>'.$row[11].'</label>
  </div>
  <div class="dropdown-divider"></div>
  <div class="container">
  <button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" value="'.$pp.'" onclick="view_cv(this.value);" data-target="#fcv">view cv</button>
  </div>
  </div>
</nav>';
    echo '<div class="overflow-auto">';
  echo "<figure>";
  echo '<ul class="tree">';
  echo '<li><code data-toggle="modal" data-target="#department_info" class="btn btn-success">board of directors</code>';
  echo '<ul>';
  tree($row1[2],0,$conn,$userid);
  echo "<li><code data-toggle='modal' onclick='parent_d=0;' data-target='#department_info' class='btn btn-success'>Add +</code></li>";
  echo "</ul>";
  echo "</li>";
  echo "</ul>";
  echo "</figure>";
  echo "</div>";
  echo "</div>";
}
 ?>

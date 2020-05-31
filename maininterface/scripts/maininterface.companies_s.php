<?php
include '../../conn_s.php';
$email = $_SESSION["name"];
$query = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
$row = mysqli_fetch_assoc($result);
$id = $row["user_id"];
$query = "SELECT * FROM users_companies WHERE user_id = '$id'";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $cip = $row['company_id'];
      $query = "SELECT * FROM companies WHERE company_id = '$cip'";
      $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
      $row1 = mysqli_fetch_assoc($result);
      echo '<input class="nav-link" style="width:100%;" name="submit" value ="'.$row1['name'].'" type="submit" />';
    }
} else {
    echo "0 results";
}
 ?>

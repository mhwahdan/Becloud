<?php
include 'conn_s.php';
echo "string";
$name = $_GET["q"];
$description  = $_GET["r"];
$cmid = $_GET["p"];
$parent = $_GET["s"];
$query = "INSERT INTO department(name,description,company_id,parent) VALUES ('$name','$description','$cmid','$parent')";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
 ?>

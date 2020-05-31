<?php
$conn = mysqli_connect('192.168.1.5','admin','P@ssw0rd123','egycloud');
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());
}
?>

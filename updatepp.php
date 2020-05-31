<?php
session_start();
$name = $_SESSION["user"][2];
$name = sha1($name);
if($_FILES["file"]["name"] != '')
{
 $test = explode('.', $_FILES["file"]["name"]);
 $location = 'pp/' . $name.'.png';
 move_uploaded_file($_FILES["file"]["tmp_name"], $location);
}
?>

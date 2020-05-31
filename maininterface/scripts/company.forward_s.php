<?php
session_start();
$_SESSION['company_name'] =  $_POST['submit'];
header("location: ../webpages/managecompany.php");
 ?>

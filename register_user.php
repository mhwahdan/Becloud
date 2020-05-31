<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
if (isset($_POST["remail"]) && $_POST['rpassword'] == $_POST['rconfirm'] ) {
  $target_dir = "cv/";
  $pp = sha1($_POST["remail"]);
  $target_file = $target_dir.'/'.$pp.'.pdf' ;
  $uploadOk = 1;  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 2000000) {
      $uploadOk = 0;
      echo '<script type="text/javascript">alert("Sorry, your file is too large.");</script>';
}
  $type =  pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
  if(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION) != 'pdf'){
      $uploadOk = 0;
      echo '<script type="text/javascript">alert("Sorry but only pdf files are allowed.");</script>';
  }
  if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
        $target_dir = "pp/";
        $pp = sha1($_POST["remail"]);
        $target_file = $target_dir.'/'.$pp.'.png' ;
        $uploadOk = 1;  // Check file size
        if(isset($_FILES["pp"]))
        {
        if ($_FILES["pp"]["size"] > 2000000) {
            $uploadOk = 0;
            echo '<script type="text/javascript">alert("Sorry, your file is too large.");</script>';
      }
        $type =  pathinfo(basename($_FILES["pp"]["name"]),PATHINFO_EXTENSION);
        if(pathinfo(basename($_FILES["pp"]["name"]),PATHINFO_EXTENSION) != 'png' && pathinfo(basename($_FILES["pp"]["name"]),PATHINFO_EXTENSION) != 'jpeg' && pathinfo(basename($_FILES["pp"]["name"]),PATHINFO_EXTENSION) != 'jpg'){
            $uploadOk = 0;
            echo '<script type="text/javascript">alert("Sorry but only jpeg or png files are allowed.");</script>';
        }
        $srcfile = $_FILES["pp"]["tmp_name"];
      }
        else
          $srcfile = "pp/addpp.svg";
        if ($uploadOk == 1) {
            if (move_uploaded_file($srcfile, $target_file)){
        include 'conn_s.php';
        //this is for registration
        $email = $_POST['remail'];
        $password = $_POST['rpassword'];
        $confirm = $_POST['rconfirm'];
        $mobile = $_POST['rmobile'];
        $id = $_POST['rid'];
        $profession = $_POST['rprofession'];
        if ($password != $confirm or $password == "") {
          header("location: register_wrong.php");
        }
        $password = sha1($password);
        $query = "INSERT INTO users (user_id,mobile,email,password,profession,origin) VALUES ( '$id','$mobile','$email','$password','$profession',NOW())";
        $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
        if($result){
          $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$randomString = '';

for ($i = 0; $i < 20; $i++) {
    $index = rand(0, strlen($characters) - 1);
    $randomString .= $characters[$index];
}
          $randomString = sha1($randomString);
          session_start();
          $_SESSION["code"] = sha1($randomString);
          $_SESSION["registrationid"] = $email;
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->SMTPAuth = 'true';
          $mail->SMTPSecure = 'ssl';
          $mail->Host = 'smtp.gmail.com';
          $mail->Port = '465';
          $mail->isHTML();
          $mail->Username = 'Becloud.12112003@gmail.com';
          $mail->Password = 'm1562000';
          $mail->setFrom('no-reply@Becloud.com');
          $mail->addAddress($email);
          $mail->Subject = "Please verify email!";
          $mail->Body = "
              your verification code is:<br><br>
              <h1><b>".$randomString."</b></h1>
          ";
          if ($mail->send())
              $msg = "You have been registered! Please verify your email!";
          else
              $msg = "Something wrong happened! Please try again!";
          echo "string";
        }
        else {
          echo '<script type="text/javascript">alert("Their seems to be a error in the server.");</script>';
                }
      }
      }
  }
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <title>cloud companies</title>  </head>
  <body>
    <div class="container">
      <div class="card">
  <div class="card-header">
    Please verify it is really you
  </div>
  <div class="card-body" style="margin:auto;">
    <h5 class="card-title">For your own security</h5>
    <?php echo '<p class="card-text">we have sent a verfication code to <b>'.$email.'<b><br>please enter that code here in order to verify that this email really belongs to you</p>'; ?>
      <input type="text" required id="code" placeholder="enter your verfication code here !!!" class="form-control">
    <button onclick="check(document.getElementById('code').value)" class="btn btn-outine-dark">Verify</button>
  </div>
</div>
    </div>
    <script>
    var counter = 0;
    function check(str) {
      document.getElementById("code").innerHTML="";
      if (counter == 3) {
        window.location.href = 'error.php';
        return;
      }
      if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
          var result = this.responseText;
          if(result == "true" )
          {
            alert("verification succesfull");
            window.location.href = 'index.php';
          }
          else {
            alert("verification failed");
            counter++;
          }
        }
      }
      xmlhttp.open("GET","checkcode.php?q="+str,true);
      xmlhttp.send();
    }
    </script>
  </body>
</html>

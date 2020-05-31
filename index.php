<!DOCTYPE html>
<?php
$index = 0;
    if (isset($_POST['lname'])){
      include 'conn_s.php';
    // Assigning POST values to variables.
    $username = $_POST['lname'];
    $password = sha1($_POST['lpassword']);
    // CHECK FOR THE RECORD FROM TABLE
    $query = "SELECT * FROM `users` WHERE email='$username' and Password='$password';";
    $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
    if(mysqli_num_rows($result) == 1){
      session_start();
      $_SESSION["user"] = mysqli_fetch_row($result);
      $_SESSION["user"][3] = NULL;
      header("location: main.php");
    }
  }
    else {
      $success = 0;
      $index = 1;
    }
    ?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <!-- capatcha -->
 <script src="https://www.google.com/recaptcha/api.js"></script>
  <title>cloud companies</title>
  </head>
  <body>
      <div class="container" style="margin:auto;padding:auto;margin-top:10%;">
        <div class="row" style="margin:auto;">
          <iframe style="width:100%;height:100%;margin:auto;margin-top:30px;margin-bottom:15px;"
    src="https://www.youtube.com/embed/fX4JeXlGuPM?autoplay=1">
    </iframe>
        </div>
        <center>
        <form method="post" action="index.php" style="width:80%;margin:auto;">
          <div class="form-group row">
            <label for="name" class="col-form-label">email</label>
              <input type="text" required class="form-control" name="lname" id="name">
          </div>
          <div class="form-group row">
            <label for="password" class="col-form-label">Password</label>
              <input type="password" required class="form-control" name="lpassword" id="password">
              <a target="_blank" style="margin-top:20px;" href="https//www.google.com">forgot password or email ?</a>
          </div>
          <div class="form-group row" style="float:right">
              <button type="submit" disabled style="width:150px;margin-top:5%;" class="btn btn-primary submission">login</button>
          </div>
          <div class="g-recaptcha row" data-expired-callback="expired" data-sitekey="6LdFlfwUAAAAAO_IiP7UPJI385sCVjKwJ_v4gezA" data-callback="recaptchaCallback"></div>


        </form>
      </center>
    </div>
    <div class="dropdown-divider"></div>
    <div class="container overflow-auto" style="margin:auto;padding:auto;">
      <form method="post" action="register_user.php" style="width:75%;margin:auto;" enctype="multipart/form-data">
<div class="row" style="margin:auto;margin-top:5%;">
          <div class="col-6" style="margin:auto;">
          <label for="mypp"><img data-toggle="tooltip" data-placement="bottom" title="Add your profile picture" class="img profilepicture" style="border-radius:50%;margin:auto;width:100%;;height:100%;;margin-top:5%;" src="addpp.svg" alt=""/>
        </div>
        <div class="col-6" style="margin:auto;">
          <label for="fileToUpload"><img data-toggle="tooltip" data-placement="bottom" title="Add your cv" class="img cv" style="margin:auto;width:100%;height:100%;margin-top:5%;" src="cv.svg" alt=""/>
       </div>
</div>
         <div class="form-group row" style="margin:auto;margin-top:2%;">
           <input required onchange="$('img.profilepicture').attr('src',window.URL.createObjectURL(this.files[0]));" hidden type="file" name="pp" id ="mypp" />
           <input required type="file" hidden name="fileToUpload" id="fileToUpload" name="cv">
</div>
        <div class="form-group row">
          <label for="email" class="col-form-label">Email</label>
            <input type="email" required name="remail" class="form-control">
        </div>
        <div class="row">
          <label for="number" class="col-form-label">mobile number</label>
            <input type="text" required name="rmobile" class="form-control">
        </div>

        <div class="form-group row">
          <label for="ID" class="col-form-label">personal ID</label>
            <input type="text" required name="rid" class="form-control">
        </div>
        <div class="form-group row">
          <label for="password" class="col-form-label">Password</label>
            <input type="password" required class="form-control" name="rpassword">
        </div>
        <div class="form-group row">
          <label for="confirmpassword" class="col-form-label">confirm password</label>
            <input type="password" required class="form-control" name="rconfirm">
        </div>
      <div class="form-group row">
      <label for="number" class="col-form-label">profession</label>
        <input type="text" required name="rprofession" class="form-control">
    </div>
        <div class="form-group row" >
            <div style="float:left;" class="form-check">
              <input class="form-check-input" onchange="document.getElementById('approve').disabled = !this.checked;" type="checkbox" id="gridCheck1">
                  <a target="_blank" href="https//www.google.com">do you agree with terms and policies</a>
            </div>
        </div>
        <div class="g-recaptcha" data-expired-callback="expired" data-sitekey="6LdFlfwUAAAAAO_IiP7UPJI385sCVjKwJ_v4gezA" data-callback="recaptchaCallback"></div>
        <div class="form-group row" style="float:left">
            <button disabled type="submit" style="width:200px;margin-top:5%;" class="btn btn-primary submission">Register</button>
        </div>
  </div>
</form>
  <script>
  function recaptchaCallback() {
      $('button.submission').attr('disabled',false);
  };
  function expired() {
      $('button.submission').attr('disabled',true);
  };

  </script>
  </body>
</html>

<!DOCTYPE html>
<?php
include 'conn_s.php';
//load user information
session_start();
$userid = $_SESSION["user"][0];
$username = $_SESSION["user"][1];
$useremail = $_SESSION["user"][2];
$userprofession = $_SESSION["user"][4];
$usermobile = $_SESSION["user"][5];
$userrating = $_SESSION["user"][9];
$userbio = $_SESSION["user"][12];
$pp = sha1($useremail);
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="scripts.js"></script>
    <title>Be cloud</title>
  </head>
  <body style="min-height:100vh;">
    <div id="result">
    </div>
    <?php
    if (isset($_FILES['cpp']) && isset($_FILES['cfiles']) && ud($_POST['cemail'])) {
      $target_dir = "documentations/";
      $target_file = $target_dir .'/'.sha1($_POST['cemail']) ;
      $uploadOk = 1;  // Check file size
      if(pathinfo(basename($_FILES["cfiles"]["name"]),PATHINFO_EXTENSION) != 'pdf'){
          $uploadOk = 0;
          echo '<script type="text/javascript">alert("Sorry but only pdf files are allowed.");</script>';
      }
      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 1)
          if (move_uploaded_file($_FILES["cfiles"]["tmp_name"], $target_file))
          {
            $target_dir = "pp/";
            $target_file = $target_dir .'/'.sha1($_POST['cname']).'.png';
            $uploadOk = 1;  // Check file size
            if(pathinfo(basename($_FILES["cpp"]["name"]),PATHINFO_EXTENSION) != 'jpg' && pathinfo(basename($_FILES["cpp"]["name"]),PATHINFO_EXTENSION) != 'jpeg' && pathinfo(basename($_FILES["cpp"]["name"]),PATHINFO_EXTENSION) != 'png'){
                $uploadOk = 0;
                echo '<script type="text/javascript">alert("Sorry but only jpg files are allowed.");</script>';
            }
              if (move_uploaded_file($_FILES["cpp"]["tmp_name"], $target_file)){
                if ($uploadOk == 1){
                $cname = $_POST["cname"];
                $cemail = $_POST["cemail"];
                $cmobile = $_POST["cmobile"];
                $cfield = $_POST["cfield"];
                $cwebsite = $_POST["cwebsite"];

                if($_POST["structure"] == 0)
                {
                  $query = "INSERT INTO companies (name,email,mobile,field,website,origin,structure) VALUES ( '$cname','$cemail','$cmobile','$cfield','$cwebsite',NOW(),2)";
                  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  $query = "SELECT * FROM companies WHERE name = '$cname'";
                  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  $companyid = mysqli_fetch_row($result);
                  $query = "INSERT INTO ownership (sender_id,sender_name,company_id,company_name,user_id,share,when_time,is_chairman,status) VALUES ( '$userid','$username','$companyid[0]','$cname','$userid',100,NOW(),true,true)";
                  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  $query = "INSERT INTO contracts (user_id,company_id,salary,level) VALUES ( '$userid','$companyid[0]',0,0)";
                  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  if ($result)
                      echo '<script type="text/javascript">alert("The company papers are being reviewed by our specialists");</script>';
                }
                else if($_POST["structure"] == 1)
                {
                $cid = $_POST['cid'];
                $owners = explode(';',$cid);
                if(isset($_POST["cooid"]) && isset($_POST["mdid"]))
                $query = "INSERT INTO companies (name,email,mobile,field,website,origin,structure) VALUES ( '$cname','$cemail','$cmobile','$cfield','$cwebsite',NOW(),0)";
                elseif(isset($_POST["cooid"]) || isset($_POST["mdid"]))
                $query = "INSERT INTO companies (name,email,mobile,field,website,origin,structure) VALUES ( '$cname','$cemail','$cmobile','$cfield','$cwebsite',NOW(),1)";
                $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                $query = "SELECT company_id FROM companies WHERE name = '$cname'";
                $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                $companyid = mysqli_fetch_row($result);
                if ($result) {
                  $cname = $_POST["cname"];
                  for ($i= 0 ; $i < count($owners) ; $i++) {
                    $current = explode(",",$owners[$i]);
                    if ($current[0] == $_POST["cmid"])
                    $query = "INSERT INTO ownership (sender_id,sender_name,company_id,company_name,user_id,share,when_time,is_chairman) VALUES ( '$userid','$username','$companyid[0]','$cname','$current[0]','$current[1]',NOW(),true)";
                    else
                    $query = "INSERT INTO ownership (sender_id,sender_name,company_id,company_name,user_id,share,when_time) VALUES ( '$userid','$username','$companyid[0]','$cname','$current[0]','$current[1]',NOW())";
                    $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  }
                if ($result) {
                  if(isset($_POST["cooid"]))
                  {
                    $coo = $_POST["cooid"];
                    $coosalary = $_POST["coosalary"];
                    $query = "INSERT INTO hiring (sender_id,user_id,company_id,salary,description,when_time,level) VALUES ('$userid','$coo','$companyid[0]','$coosalary','You are offered a job as a Cheif operating officer for a starting company',NOW(),0)";
                    $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  }
                  if(isset($_POST["mdid"]))
                  {
                    $md = $_POST["mdid"];
                    $mdsalary = $_POST["mdsalary"];
                    $query = "INSERT INTO hiring (sender_id,user_id,company_id,salary,description,when_time,level) VALUES ('$userid','$md','$companyid[0]','$mdsalary','You are offered a job as a Cheif executive officer for a starting company',NOW(),0)";
                    $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
                  }
                }
                  if ($result)
                      echo '<script type="text/javascript">alert("company ownership requests have been sent and the company papers are being reviewed by our specialists");</script>';
                }
              }
          }
        }
      }
    }
     ?>
<div class="row" id="test">
</div>
<div class="row border-bottom" style="width:100vw;margin:auto;padding:auto;" >
  <nav class="navbar navbar-light bg-dark" style="width:100vw;">
    <?php echo '<a data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation"><img class="img profilepicture navbar-brand" style="border-radius:50%;width:10vh;height:10vh;" src="pp/'.$pp.'.png" alt=""/></a>';?>
    <div class="collapse navbar-collapse p-4" id="navbarText">
              <?php
                    echo '<div class="container" style="text-align:center;">';
                    echo '<label style="margin:auto;" for="mypp"><img data-toggle="tooltip" title="Change your profile picture" class="img profilepicture" style="border-radius:50%;width:20vw;height:20vw;margin:auto;" src="pp/'.$pp.'.png" alt=""/></label>';
                    echo "</div>";
                    echo '<div class="container" style="text-align:center;margin:auto;font-size:25px;color:white;" >';
                    echo '<label style="margin:auto;">'.$username.'<br>email:'.$useremail.'<br>profession:'.$userprofession.'<br></label>';
                    echo "</div>";
                    echo "<div style='margin:auto;text-align:center;font-size:25px;'>";
                    for ($i = 0; $i < $userrating ; $i++)
                      echo '<span class="fa fa-star " style="color:orange;"></span>';
                      for ($i = $userrating;$i < 5 ; $i++)
                        echo '<span class="fa fa-star text-dark"></span>';
                        echo "</div>";

              ?>
              <div class="dropdown-divider"></div>
              <div class="container" style="margin:auto;font-size:25px;color:white;">
                <?php echo '<label style="text-align:center;margin:auto;">'.$userbio.'</label>'; ?>
              </div>
              <div class="dropdown-divider"></div>
              <div class="container">
                <button type="button" class="btn btn-primary btn-lg btn-block" href="#" data-toggle="modal" data-target="#personalprofile">My profile</button>
              <button type="button" onclick="window.location.href = 'index.php';window.location.replace('index.php');" class="btn btn-primary btn-lg btn-block">Logout</button>
            </div>
      </div>
    </div>
  </nav>
</div>
  <div class="row" style="width:100vw;margin:auto;">
  <div class="overflow-auto" style="width:100vw;margin-left:auto;margin-right:auto;padding:0px;min-height:87vh;">
    <nav>
  <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="nav-home" aria-selected="true">
      <img src="dashboard.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#search" role="tab" aria-controls="nav-profile" aria-selected="false">
      <img src="search.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-item nav-link" id="nav-company-create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="nav-contact" aria-selected="false">
      <img src="business.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-item nav-link" id="nav-notifications-tab" data-toggle="tab" onclick="notifications();" href="#notify" role="tab" aria-controls="nav-contact" aria-selected="false">
      <img src="notifications.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-link nav-item" href="#mycompanies" onclick="showcompanies();" data-toggle="tab"  role="tab" aria-haspopup="true" aria-controls="nav-contact" aria-expanded="false">
      <img src="mycompanies.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-item nav-link" id="nav-message-tab" data-toggle="tab" href="#message" role="tab" aria-controls="nav-contact" aria-selected="false" onclick="viewmsg();">
      <img src="notes.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
    <a class="nav-item nav-link" onclick="showtasks()" id="nav-tasks-tab" data-toggle="tab" href="#tasks" role="tab" aria-controls="nav-contact" aria-selected="false">
      <img src="tasks.svg" style="width:7vh;height:7vh;" class="d-inline-block align-top" alt="">
    </a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade bg-dark" style="margin-top:15px;margin:auto;" id="mycompanies" role="tabpanel" aria-labelledby="nav-contact-tab">
    <div id="carouselExampleControls1" style="height:58vh;" class="carousel slide" data-ride="carousel">
      <div id="companies_structures" class="carousel-inner">
      </div>

    </div>
    <div class="row" style="margin:auto;padding:auto;">
    <a href="#carouselExampleControls1" role="button" data-slide="prev">
  <span aria-hidden="true"><img class="img" style="margin-left:10vw;margin-right:50vw;width:15vw;height:15vw;border-radius:50%;" src="left.svg"></img></span>
</a>
<a href="#carouselExampleControls" role="button" data-slide="next">
<img class="img" style="width:15vw;height:15vw;border-radius:50%;" src="right.svg"></img></a>
</div>
  </div>
<div  class="tab-pane fade show active" id="tasks" role="tabpanel" aria-labelledby="nav-home-tab">
  <div id="carouselExampleCaptions" data-touch="true" data-interval="false" style="background-color:grey;" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
      <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div id="tickets" class="carousel-inner">

    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

  <div style="margin-top:10px" class="tab-pane fade" id="search" role="tabpanel" aria-labelledby="nav-profile-tab">
      <input class="form-control" type="text" style="margin:auto;width:80%;" placeholder="search for anything from here" size="30" onkeyup="showResult(this.value)"/>
    <div style="padding-top:10px;" id="livesearch"></div>
  </div>
  <div class="tab-pane fade overflow-auto" style="margin-top:15px;min-height:80vh;" id="notify" role="tabpanel" aria-labelledby="nav-contact-tab">
  </div>
  <div class="tab-pane fade overflow-auto" style="margin-top:15px;" id="create" role="tabpanel" aria-labelledby="nav-contact-tab">
    <form method="post" action="main.php" enctype="multipart/form-data">
      <div class="row" style="margin:auto;">
  <input required type="file" hidden class="custom-file-input" name="cpp" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
  <label for="inputGroupFile01" style="margin:auto;"><img class="img" style="width:30vh;height:30vh;border-radius:50%;" src="company.svg"></img></label>
</div>
<div class="container">
<div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputEmail4">company name</label>
    <input required name="cname" type="text" class="form-control" placeholder="example company name">
  </div>
  <div class="form-group col-md-6">
    <label for="inputPassword4">mobile</label>
    <input required name="cmobile" type="text" class="form-control" placeholder="example mobile number">
  </div>
</div>
<div class="form-group">
  <label for="inputAddress">email</label>
  <input required style="margin-bottom: :20px;" name="cemail" type="email" class="form-control" id="inputAddress" placeholder="example@email.com">
</div>
<label style="margin-bottom:10px;">Structure of the company</label>
<div class="form-check">
  <input class="form-check-input"  type="radio" name="structure" id="exampleRadios1" value="0" checked onclick="document.getElementById('cid').disabled=true;document.getElementById('cmid').disabled=true;document.getElementById('cid').value='';document.getElementById('cmid').value='';document.getElementById('check_coo').disabled=true;document.getElementById('check_md').disabled=true;document.getElementById('check_coo').checked=false;document.getElementById('check_md').checked=false;document.getElementById('coo').value ='';document.getElementById('coos').value='';document.getElementById('Managingdirectors').value ='';document.getElementById('Managingdirector').value='';document.getElementById('coo').disabled = true;document.getElementById('coos').disabled = true;document.getElementById('coo').value ='';document.getElementById('coos').value='';document.getElementById('Managingdirector').disabled = true;document.getElementById('Managingdirectors').disabled = true;document.getElementById('Managingdirectors').value ='';document.getElementById('Managingdirector').value='';">
  <label class="form-check-label" for="exampleRadios1">
    Sole Proprietorship
  </label>
</div>
<div class="form-check">
  <input class="form-check-input" onclick="document.getElementById('cid').disabled=false;document.getElementById('cmid').disabled=false;document.getElementById('check_coo').disabled=false;document.getElementById('check_md').disabled=false;" type="radio" name="structure" id="exampleRadios2" value="1">
  <label class="form-check-label" for="exampleRadios2">
    Partnership
  </label>
</div>
<div class="form-group">
  <label style="margin-top:20px;" for="inputAddress2">National ID of share owners and there share % in the following formula id1,15;id2,20;...,etc;</label>
  <input  disabled required name="cid" id="cid" type="text" class="form-control"  placeholder="example id 1,15;example id 2,20;">
</div>
<div class="form-group">
  <label for="inputAddress2">National ID of Chair man (must be one of the chair holders)</label>
  <input disabled required name="cmid" id="cmid" type="text" class="form-control"  placeholder="National ID of Chair man">
</div>
<div class="form-group">
  <input type="checkbox" id="check_coo" disabled onchange="document.getElementById('coo').disabled = !document.getElementById('coo').disabled;document.getElementById('coos').disabled = !document.getElementById('coos').disabled;document.getElementById('coo').value ='';document.getElementById('coos').value='';">
  <label for="inputAddress2">National ID of Cheif operating officer</label>
  <input required disabled name="cooid" id="coo" type="text" class="form-control"  placeholder="National ID of Cheif operating officer">
</div>
<div class="form-group">
  <label for="inputAddress2">Salary of Cheif operating officer</label>
  <input required disabled id="coos" name="coosalary" type="number" class="form-control" >
</div>
<div class="form-group">
  <input type="checkbox" disabled id="check_md" onchange="document.getElementById('Managingdirector').disabled = !document.getElementById('Managingdirector').disabled;document.getElementById('Managingdirectors').disabled = !document.getElementById('Managingdirectors').disabled;document.getElementById('Managingdirectors').value ='';document.getElementById('Managingdirector').value='';">
  <label for="inputAddress2">National ID of Cheif executive officer</label>
  <input disabled id="Managingdirector" required name="mdid" type="text" class="form-control"  placeholder="National ID of Cheif operating officer">
</div>
<div class="form-group">
  <label  for="inputAddress2">Salary of Managing director</label>
  <input disabled id="Managingdirectors" required name="mdsalary" type="number" class="form-control" >
</div>
<div class="form-group">
  <label for="inputAddress2">Website ( optional )</label>
  <input required name="cwebsite" type="text" class="form-control"  placeholder="www.example.com">
</div>
<div class="form-group">
  <label for="inputCity">field</label>
  <input required name="cfield" style="width:50%;" type="text" class="form-control" id="inputCity">
  <div class="input-group" style="margin-top:20px;width:50%;">
  <div class="custom-file">
    <input type="file"name="cfiles" class="custom-file-input" id="inputGroupFile04">
    <label class="custom-file-label" for="inputGroupFile04">upload company papers</label>
  </div>
</div>
</div>
<input type="submit" class="btn btn-dark" style="float:right;margin-left:15px;margin-bottom:20px;"  name="csubmit" value="create company">
    </form>
  </div>
</div>
<div  class="tab-pane fade show" id="message" role="tabpanel" aria-labelledby="nav-home-tab" style="min-height:84vh;">

</div>
</div>




</div>
</div>
</div>
<div class="modal fade" data-backdrop="static" id="cmprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Your company profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary admin">update profile ?</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" data-backdrop="static" id="department" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Manage department from here</h5>
        <button type="button" onclick="head=0;" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="department_r" class="modal-body">
        <div class="d-flex justify-content-center">
        <div class="spinner-border text-dark" style="width:10vh;height:10vh;" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="head=0;" data-dismiss="modal">Close</button>
        <button type="button" disabled data-toggle="modal" data-target="#rmdepartment" class="btn btn-danger admin">Remove department</button>
        <button type="button" disabled data-toggle="modal" data-target="#postjobform" class="btn btn-primary admin">Post a job offer in this department</button>
        <button type="button" disabled data-toggle="modal" data-target="#hireform" class="btn btn-primary admin">Hire someone</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" data-backdrop="static" id="hireform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Please fill the contract form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleInputEmail1">Employee name</label>
            <input type="text" class="form-control" onkeyup="searchemployee(this.value);" id="hire_form_name" aria-describedby="emailHelp">
            <div class="overflow-auto" style="max-height:50vh;;" id="Employee">
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Job description</label>
            <input type="text" style="height:15vh;" class="form-control" id="hire_form_description">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">salary</label>
            <input type="number" style="width:50%;" class="form-control" id="hire_form_salary">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="hire();" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="ticketmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Fill your task information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">From: </span>
  </div>
  <input type="text" class="form-control" aria-label="Username" disabled id="ticket_sender" aria-describedby="basic-addon1">
</div>
<div class="input-group mb-3">
<div class="input-group-prepend">
  <span class="input-group-text" id="basic-addon1">To: </span>
</div>
<input type="text" required class="form-control" aria-label="Username" onkeyup="filtercontacts(this.value,'filter_receive',this.id)" disabled id="ticket_receiver" aria-describedby="basic-addon1">
</div>
<div id="filter_receive">
</div>
<div class="input-group mb-3">
<div class="input-group-prepend">
  <span class="input-group-text" id="basic-addon1">dead line: </span>
</div>
<input type="datetime-local" required class="form-control" aria-label="Username" id="ticket_deadline" aria-describedby="basic-addon1">
</div>
<div class="form-group">
  <label for="exampleFormControlTextarea1">Enter ticket body:-</label>
  <textarea onclick="texts();" required class="form-control" id="ticket_body" rows="10"></textarea>
</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="msg=nl2br(document.getElementById('ticket_body').value);task(action,tid);" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="messagesmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Make your message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">From: </span>
  </div>
  <input type="text" class="form-control" aria-label="Username" disabled id="sender_id" aria-describedby="basic-addon1">
</div>
<div class="input-group mb-3">
<div class="input-group-prepend">
  <span class="input-group-text" id="basic-addon1">To: </span>
</div>
<input type="text" class="form-control" aria-label="Username" onkeyup="filtercontacts(this.value,'filter_receive',this.id)" disabled id="receiver_id" aria-describedby="basic-addon1">
</div>
<div id="filter_receive">
</div>
<div class="input-group mb-3">
<div class="input-group-prepend">
  <span class="input-group-text" id="basic-addon1">Subject: </span>
</div>
<input type="text" class="form-control" aria-label="Username" id="message_subject" aria-describedby="basic-addon1">
</div>
<div class="form-group">
  <label for="exampleFormControlTextarea1">Enter message body:-</label>
  <textarea class="form-control" onclick="texts();" id="message_body" rows="10"></textarea>
</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="msg=nl2br(document.getElementById('message_body').value);message();" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal to show department information -->
<div class="modal fade" data-backdrop="static" id="department_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add department</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="exampleFormControlInput1">department name</label>
            <input type="text" class="form-control" id="n_departmentname" placeholder="example department name">
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Department description</label>
            <input type="text" class="form-control" id="n_description" height="50px;" placeholder="example description"/>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="addepartment();" class="btn btn-primary admin">Add department</button>
      </form>
      </div>
    </div>
  </div>
</div>
<div id="fcv" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body overflow-auto" id="rcv">
              <div >
                <div class="modal-footer">
                </div>
            </div>

        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="personalprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Your profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row" style="margin:auto;">
        <div class="col-6">
      <?php echo '<label for="mypp"><img data-toggle="tooltip" data-placement="bottom" class="img profilepicture" title="Add your profile picture" class="img profilepicture" style="border-radius:50%;margin:auto;width:30vh;height:30vh;margin-top:5%;" src="pp/'.sha1($useremail).'.png" alt=""/></label>' ?>
      </div>

        <div class="col-6">
      <?php echo '<label value="'.sha1($useremail).'" onclick="view_cv(this.value);" data-toggle="modal" data-target="#cv"><img data-toggle="tooltip" data-placement="bottom" title="Add your cv" class="img cv" style="margin:auto;width:30vh;height:30vh;margin-top:5%;" src="cv.svg" alt=""/></label>' ?>
       </div>
         <div class="row" style="margin:auto;margin-top:2%;">
           <input hidden onchange="$('img.profilepicture').attr('src',window.URL.createObjectURL(this.files[0]));" type="file" name="mypp" id ="mypp" />
</div>
</div>
      <div class="row" style="margin:auto;">
      <div class="container">
        <div class="form-group">
  <label for="exampleInputEmail1">Name</label>
  <?php
  echo '  <input type="text" id="myname" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" disabled value="'.$username.'">';
   ?>
  <small id="emailHelp" class="form-text text-muted">This cannot be changed as changing it could be used in identitiy theft.</small>
</div>
        <div class="form-group">
  <label for="exampleInputEmail1">Email address</label>
  <?php
  echo '  <input type="email" class="form-control" id="myemail" aria-describedby="emailHelp" value="'.$useremail.'">';
   ?>
  <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
</div>
<div class="row" style="margin:auto;">
<div class="form-group">
  <label for="exampleInputPassword1">Profession</label>
  <?php
  echo '  <input type="text" class="form-control" style="width:25vw;margin-right:3vw;" id="myprofession" value="'.$userprofession.'">';
   ?>
</div>
<div class="form-group">
  <label for="exampleInputPassword1">mobile</label>
  <?php
  echo '<input type="number" style="width:25vw;" class="form-control" id="mymobile" value="'.$usermobile.'">';
   ?>
</div>
</div>
<div class="form-group">
  <label for="exampleFormControlTextarea1">Enter your bio:-</label>
  <?php
  echo '<textarea onclick="texts();" placeholder="'.$userbio.'" class="form-control" id="mybio" rows="10"></textarea>';
   ?>
</div>
      </div>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="msg=nl2br(document.getElementById('mybio').value);updateprofile();" class="btn btn-primary">Update profile</button>
      </div>
    </div>
  </div>
</div>



<?php
if (isset($_POST["cv"])) {
  $target_dir = "cv/";
  $target_file = $target_dir .'/'.$pp.'.pdf' ;
  $uploadOk = 1;  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 50000000) {
      $uploadOk = 0;
      echo '<script type="text/javascript">alert("Sorry, your file is too large.");</script>';
  // Allow certain file formats
}
  $type =  pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
  if(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION) != 'pdf'){
      $uploadOk = 0;
      echo '<script type="text/javascript">alert("Sorry but only pdf files are allowed.");</script>';
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
      echo '<script type="text/javascript">alert("your Cv has been uploaded succesfully.");</script>';
  }
}
 ?>

 <!-- Modal -->
 <div class="modal fade" id="rprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div id="foreignprofile" class="modal-body bg-dark">

         <div>


         </div>
       </div>
     </div>
   </div>
 </div>

 <!-- Modal -->
 <div id="cv" class="modal fade"  role="dialog">
     <div class="modal-dialog modal-xl">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-body overflow-auto">

                 <?php echo '<embed src="cv/'.$pp.'.pdf"frameborder="0" width="100%" height="500vh">' ?>

                 <div class="modal-footer">
                   <form method="post" action="main.php" enctype="multipart/form-data">
                     <div class="input-group mb-3">
                       <div class="input-group-prepend">
                   <input class="btn btn-dark" type="submit" name="cv" value="change CV"/>
                 </div>
                     <div class="custom-file">
                           <input type="file" name="fileToUpload" id="fileToUpload" class="custom-file-input" name="cv">
                         <label class="custom-file-label" for="fileToUpload">Choose file</label>
                       </div>
                     </div>
                   </form>
                 </div>
             </div>

         </div>
     </div>
 </div>
 <script>
 $(document).ready(function(){
  $(document).on('change', '#mypp', function(){
   var name = document.getElementById("mypp").files[0].name;
   var form_data = new FormData();
   var ext = name.split('.').pop().toLowerCase();
   if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
   {
    alert("Invalid Image File");
   }
   var oFReader = new FileReader();
   oFReader.readAsDataURL(document.getElementById("mypp").files[0]);
   var f = document.getElementById("mypp").files[0];
   var fsize = f.size||f.fileSize;
   if(fsize > 2000000)
   {
    alert("Image File Size is very big");
   }
   else
   {
    form_data.append("file", document.getElementById('mypp').files[0]);
    $.ajax({
     url:"updatepp.php",
     method:"POST",
     data: form_data,
     contentType: false,
     cache: false,
     processData: false,
     beforeSend:function(){
     },
     success:function(data)
     {
    }
    });
   }
  });
 });
 </script>
  </body>
</html>

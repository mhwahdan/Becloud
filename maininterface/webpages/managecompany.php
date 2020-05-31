<!DOCTYPE html>
<?php
// Start the session
session_start();
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>egycloudcompanies.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
    function showResult(str) {
      if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
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
          document.getElementById("livesearch").innerHTML=this.responseText;
          document.getElementById("livesearch").style.border="none";
        }
      }
      xmlhttp.open("GET","../../livesearch.php?q="+str,true);
      xmlhttp.send();
    }
    </script>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light navbar navbar-dark bg-dark">
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <?php echo '<a class="navbar-brand" style="padding-right:2vw;" href="../../maininterface/webpages/main interface.php">'.$_SESSION["name"].'<span class="sr-only">(current)</span></a>';?>
        </li>
        <li class="nav-item active">
          <a class="nav-link" style="padding-right:2vw;" href="../../profiles/webpages/myprofile.php">profile</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" style="padding-right:2vw;" href="../../registration&login/webpages/companyregister.php">Create a company</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" style="padding-right:25vw;" href="#">Balance sheet</a>
        </li>
        <li class="nav-item active">
          <!-- Button trigger modal -->
<label class="nav-link">Acess the whole world from here >></label>
</li>
<li class="nav-item active">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
</button>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalScrollableTitle">Search for a comapny or someone</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" >
          <form class="form-inline my-2 my-lg-0" method="get" action="../../profiles/scripts/forward_s.php">
            <input class="form-control" type="text" style="width:80%;" size="30" onkeyup="showResult(this.value)"/>
            <button class="btn btn-outline-success my-2 my-sm-0" style="width:20%;" type="submit">Search</button><br>
            </form>
          <div style="padding-top:10px;" id="livesearch"></div>
        </div>
        <div class="modal-footer">
          <h5 class="modal-title" id="exampleModalScrollableTitle">www.egycloud.com</h5>
        </div>
      </div>
    </div>
  </div>
  <div class="row" >
  <div class="col-sm-3 overflow-auto" style="max-height:100vh;">
    <div class="row">
    <?php echo '<img style="height:250px;" src="../../pp/'.sha1($_SESSION["name"]).'" class="card-img-top" alt="you profile photo">' ?>
  </div>
    <nav class="nav flex-column nav-tabs" class="overflow-auto">
      <a class="nav-link" href="personalcontacts.php">contacts</a>
      <a class="nav-link" href="#">send task</a>
      <a class="nav-link" href="#">report a problem</a>
      <div class="dropdown-divider"></div>
      <a class="nav-link" href="../../profiles/webpages/mycompanyprofile.php">company profile</a>
      <div class="dropdown-divider"></div>
      <label class="nav-link">Departments</label>
      <form method="post" action="../scripts/adddepartment_s.php">
      <div class="input-group mb-3">
        <input type="text" class="form-control" name="department" placeholder="Add a new department" aria-label="Recipient's username" aria-describedby="button-addon2">
        <div class="input-group-append">
          <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
        </div>
      </div>
    </form>
<form method="post" action="managecompany.php">
<?php include '../scripts/departments.companies_s.php'; ?>
</form>
</nav>
  </div>
  <div class="col-sm-9" style="max-height:100vh;padding-top:50px;">
    <div class="overflow-auto" style="max-height:100vh;" >
      <div class="alert alert-dark" role="alert">
  <table class="table table-hover table-borderless">
    <thead>
      <tr>
        <th scope="col"></th>
        <th scope="col">name</th>
        <th scope="col">number</th>
        <th scope="col">email</th>
        <th scope="col" style="text-align:center;" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php include '../scripts/loaddepartment_s.php' ?>
      </tr>
    </tbody>
  </table>
</div>
    </div>
  </div>
  </body>
</html>

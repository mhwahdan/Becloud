  <?php
  session_start();
  $userid = $_SESSION["user"][0];
  $username = $_SESSION["user"][1];
  include 'conn_s.php';
  echo "<div class='carousel-item active overflow-auto'>";
  $query = "SELECT * FROM tickets WHERE receiver_id = '$userid' AND status = 0 ";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result)) {
    echo "<div id='ticket-".$row["ticket_id"]."' style='margin:10%;margin-top:2%;max-height:25%;' class='alert alert-success alert-dismissible fade show' role='alert'>";
    echo "<div class='row'>";
    echo "<div class='col-8'>";
    echo '<label>From: '.$username.'<br>To: '.$row["receiver_name"].'<br>dead line: '.$row["due_date"].'<br><br>'.str_replace("<t>","&emsp;&emsp;",$row["description"]).'</label>';
    echo "</div>";
    echo "<div class='col-4'>";
    $date=date_create($row["due_date"]);
    $part1 = date_format($date,"Y-m-j");
    $part2 = date_format($date,"H:i");
    $cmd = "document.getElementById('ticket_deadline').value='".$row['due_date']."';document.getElementById('ticket_receiver').disabled=false;document.getElementById('ticket_sender').placeholder = '".$row['sender_name']."';document.getElementById('ticket_receiver').value='".$row["receiver_name"]."';document.getElementById('ticket_body').value='".$row["description"]."';document.getElementById('ticket_deadline').value='".$part1."T".$part2."';";
    $ssh = "tid=".$row["ticket_id"].";msg=nl2br(document.getElementById('rcomment-".$row["ticket_id"]."').value)";
    echo '<button class="btn btn-dark float-right" onclick="'.$ssh.';task(1,'.$row["ticket_id"].');" data-toggle="modal">Submit</button>';
    echo "</div>";
    echo "</div>";
    echo '<div class="row" style="margin:auto;">
    <textarea onclick="texts();" class="form-control" placeholder="Write a brief of what you have done." id="rcomment-'.$row["ticket_id"].'" rows="5"></textarea>
    </div>';
    echo "<div class='row foat-center' style='margin:auto;text-align:center;'><label>Time of sending: ".$row["time_t"]."</label></div>";
    echo "</div>";
    }
echo "</div>";
echo "<div class='carousel-item overflow-auto'>";
  $query = "SELECT * FROM tickets WHERE sender_id = '$userid' AND status = 0";
  $result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
  while($row = mysqli_fetch_assoc($result)) {
    echo "<div id='ticket-".$row["ticket_id"]."' style='margin:10%;margin-top:2%;max-height:25%;' class='alert alert-success alert-dismissible fade show' role='alert'>";
    echo "<div class='row'>";
    echo "<div class='col-8'>";
    echo '<label>From: '.$username.'<br>To: '.$row["receiver_name"].'<br>dead line: '.$row["due_date"].'<br><br>'.$row["description"].'</label>';
    echo "</div>";
    echo "<div class='col-4'>";
    $date=date_create($row["due_date"]);
    $part1 = date_format($date,"Y-m-j");
    $part2 = date_format($date,"H:i");
    $cmd = "document.getElementById('ticket_deadline').value='".$row['due_date']."';document.getElementById('ticket_receiver').disabled=false;document.getElementById('ticket_sender').placeholder = '".$row['sender_name']."';document.getElementById('ticket_receiver').value='".$row["receiver_name"]."';document.getElementById('ticket_body').value=br2nl('".$row["description"]."');document.getElementById('ticket_deadline').value='".$part1."T".$part2."';";
    echo '<div class="btn-group-vertical">';
    echo '<button class="btn btn-dark float-right" onclick="tid = '.$row["ticket_id"].';task(-1,'.$row["ticket_id"].');" style="height:25%;margin-top:10%;">With draw task</button>';
    echo '<button class="btn btn-dark float-right" onclick="tid='.$row["ticket_id"].';action=-2;'.$cmd.'" data-toggle="modal" data-target="#ticketmodal" style="height:25%;">Edit task</button>';
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "<div class='row foat-center' style='margin:auto;text-align:center;'><label>Time of sending: ".$row["time_t"]."</label></div>";
    echo "</div>";
  }
echo "</div>";
echo "<div class='carousel-item overflow-auto'>";
$query = "SELECT * FROM tickets WHERE sender_id = '$userid' AND status = 1";
$result = mysqli_query($conn, $query) or die("connection falied".mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)) {
  echo "<div style='margin:10%;margin-top:2%;max-height:25%;' class='alert alert-success alert-dismissible fade show' role='alert'>";
  echo "<div  id='ticket-".$row["ticket_id"]."' class='row'>";
  echo "<div class='col-8'>";
  echo '<label>From: '.$username.'<br>To: '.$row["receiver_name"].'<br>dead line: '.$row["due_date"].'<br><br>'.$row["description"].'<br><br>Briefing: '.$row["comment"].'</label>';
  echo "</div>";
  echo "<div class='col-4'>";
  $date=date_create($row["due_date"]);
  $part1 = date_format($date,"Y-m-j");
  $part2 = date_format($date,"H:i");
echo '<div class="rate">
    <input type="radio" id="star5" onclick="review=this.value;" name="rate='.$row["ticket_id"].'" value="5" />
    <label for="star5" onclick="review=this.value;" title="excellent">5 stars</label>
    <input type="radio" onclick="review=this.value;" id="star4" name="rate='.$row["ticket_id"].'" value="4" />
    <label for="star4" onclick="review=this.value;" title="very good">4 stars</label>
    <input type="radio" onclick="review=this.value;" id="star3" name="rate='.$row["ticket_id"].'" value="3" />
    <label for="star3" onclick="review=this.value;" title="good">3 stars</label>
    <input type="radio" onclick="review=this.value;" id="star2" name="rate='.$row["ticket_id"].'" value="2" />
    <label for="star2" onclick="review=this.value;" title="bad">2 stars</label>
    <input type="radio" onclick="review=this.value;" id="star1" name="rate='.$row["ticket_id"].'" value="1" />
    <label for="star1" onclick="review=this.value;" title="very bad">1 star</label>
  </div>';
  echo '<button class="btn btn-dark float-right" onclick="freview('.$row["ticket_id"].',review)">Review</button>';
  echo "</div>";
  echo "<div class='row' style='margin:auto;'>";
  echo "<label>".$row["time_t"]."</label>";
  echo "</div>";
  echo "</div>";
}
echo "</div>";
?>

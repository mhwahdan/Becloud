var parent_d = 0;
var action = 0;
var company_s;
var department_s;
var admin = 1;
var head = 0;
var msg = "";
var review = 0;
var tid = 0;
function texts(){
  var textareas = document.getElementsByTagName('textarea');
  var count = textareas.length;
  for(var i=0;i<count;i++){
  textareas[i].onkeydown = function(e){
      if(e.keyCode==9 || e.which==9){
          e.preventDefault();
          var s = this.selectionStart;
          this.value = this.value.substring(0,this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
          this.selectionEnd = s+1;
      }
  }
  }
}
function nl2br(str){
str = str.replace(/(?:\r\n|\r|\n)/g, '<br>');
return str.replace(/\t/g, '<t>');

}
function br2nl(str){
  str = str.replace(/<br>/g,'\n');
return str.replace(/<t>/g,'\t');
}
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
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}
function view_cv(str) {
    document.getElementById("rcv").innerHTML="";
    document.getElementById("rcv").style.border="0px";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("rcv").innerHTML=this.responseText;
      document.getElementById("rcv").style.border="none";
    }
  }
  xmlhttp.open("GET","findcv.php?q="+str,true);
  xmlhttp.send();
}
function searchemployee(str) {
  if (str.length==0) {
    document.getElementById("Employee").innerHTML="";
    document.getElementById("Employee").style.border="0px";
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
      document.getElementById("Employee").innerHTML=this.responseText;
      document.getElementById("Employee").style.border="none";
    }
  }
  xmlhttp.open("GET","search.php?q="+str+"&p="+company_s+"&s="+department_s,true);
  xmlhttp.send();
}
function make_admin(){
  if (admin == 1)
  {
    var x = document.getElementsByClassName("admin");
    var i;
    for (i = 0; i < x.length; i++) {
    x[i].disabled = false;
}
  }
  else {
    {
      var x = document.getElementsByClassName("admin");
      var i;
      for (i = 0; i < x.length; i++) {
      x[i].disabled = true;
}
    }
  }
}
function make_head(){
  if (head == 1 || admin ==1)
  {
    var x = document.getElementsByClassName("head");
    var i;
    for (i = 0; i < x.length; i++) {
    x[i].disabled = false;
}
  }
  else {
    {
      var x = document.getElementsByClassName("head");
      var i;
      for (i = 0; i < x.length; i++) {
      x[i].disabled = true;
}
    }
  }
}
function viewmsg() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("message").style.border="0px"
      document.getElementById("message").innerHTML=this.responseText;
      document.getElementById("message").style.border="none";
    }
  }
  document.getElementById("message").innerHTML='<div class="d-flex justify-content-center"><div class="spinner-border text-dark" style="width:10vh;height:10vh;margin-top:35vh;" role="status"><span class="sr-only">Loading...</span></div></div>';
  xmlhttp.open("GET","showmsg.php",true);
  xmlhttp.send();
}
function showcompanies() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("companies_structures").style.border="0px"
      document.getElementById("companies_structures").innerHTML=this.responseText;
      document.getElementById("companies_structures").style.border="none";
      make_admin();
    }
  }
  document.getElementById("companies_structures").innerHTML='<div class="d-flex justify-content-center"><div class="spinner-border text-dark" style="width:10vh;height:10vh;margin-top:35vh;" role="status"><span class="sr-only">Loading...</span></div></div>';
  xmlhttp.open("GET","showcompanies.php",true);
  xmlhttp.send();
}

function showdeparmtent() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("department_r").innerHTML="";
      document.getElementById("department_r").style.border="0px"
      document.getElementById("department_r").innerHTML=this.responseText;
      document.getElementById("department_r").style.border="none";
      make_admin();
      make_head();
    }
  }
  xmlhttp.open("GET","showdepartment.php?q="+department_s+"&p="+admin+"&r="+company_s,true);
  xmlhttp.send();
}

function addepartment() {
  q = document.getElementById("n_departmentname").value;
  r = document.getElementById("n_description").value;
  document.getElementById("n_departmentname").value = "";
  document.getElementById("n_description").value = "";
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("test").innerHTML=this.responseText;
      document.getElementById("test").style.border="none";
    }
  }
  xmlhttp.open("GET","addepartment.php?q="+q+"&p="+company_s+"&r="+r+"&s="+parent_d,true);
  xmlhttp.send();
  showcompanies(company_s);
  }

  function message(){
    q = document.getElementById("receiver_id").value;
    p = document.getElementById("message_body").value;
    r = document.getElementById("message_subject").value;
    document.getElementById("receiver_id").value = "";
    document.getElementById("message_body").value = "";
    document.getElementById("receiver_id").disabled = false;
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("test").innerHTML=this.responseText;
        document.getElementById("test").style.border="none";
      }
    }
    xmlhttp.open("GET","sendmessage.php?q="+q+"&p="+msg+"&r="+r,true);
    xmlhttp.send();
  }
  function action(str,value) {
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("test").innerHTML=this.responseText;
        document.getElementById("test").style.border="none";
      }
    }
    xmlhttp.open("GET","employeeaction.php?q="+str+"&p="+company_s+"&r="+value+"&s="+department_s+"&x="+parent_d,true);
    xmlhttp.send();
    showdeparmtent();
    }
  function filtercontacts(str,location,id)
  {
    if (str.length==0) {
      document.getElementById(location).innerHTML="";
      document.getElementById(location).style.border="0px";
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
        document.getElementById(location).innerHTML=this.responseText;
        document.getElementById(location).style.border="none";
      }
    }
    xmlhttp.open("GET","filtercontacts.php?q="+str+"&p="+id+"&s="+location,true);
    xmlhttp.send();
  }
  function hire() {
    q = document.getElementById("hire_form_name").value;
    r = document.getElementById("hire_form_description").value;
    s = document.getElementById("hire_form_salary").value;
    document.getElementById("hire_form_name").value = "";
    document.getElementById("hire_form_description").value = "";
    document.getElementById("hire_form_salary").value = "";
    if (window.XMLHttpRequest) {
      // code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("test").innerHTML=this.responseText;
        document.getElementById("test").style.border="none";
      }
    }
    xmlhttp.open("GET","hire.php?q="+q+"&p="+company_s+"&r="+r+"&s="+s+"&x="+department_s,true);
    xmlhttp.send();
    }

function reply(value,str,select) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  if (select == 0){
  xmlhttp.open("GET","reply_own.php?q="+str+"&p="+value,true);
  document.getElementById("own"+str).innerHTML="";
  document.getElementById("own"+str).style.border="0px";
}
  else if (select == 1) {
  xmlhttp.open("GET","reply_hiring.php?q="+str+"&p="+value,true);
  document.getElementById("hire"+str).innerHTML="";
  document.getElementById("hire"+str).style.border="0px";
  }
  xmlhttp.send();
}
function notifications() {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("notify").innerHTML=this.responseText;
      document.getElementById("notify").style.border="none";
    }
  }
  xmlhttp.open("GET","notifications.php",true);
  xmlhttp.send();
}

function task(value,str){
  if (value == 0 || value == -2)
  {
  q = document.getElementById("ticket_receiver").value;
  p = document.getElementById("ticket_body").value;
  r = document.getElementById("ticket_deadline").value;
  document.getElementById("ticket_receiver").value = "";
  document.getElementById("ticket_body").value = "";
  document.getElementById("ticket_receiver").disabled = false;
  }
  else {
    q=0;
    p=0;
    r=0;
    if(value != -1)
    document.getElementById("ticket-"+str).innerHTML = "This task has been submitted succesfully";
    else
    document.getElementById("ticket-"+str).innerHTML = "This task has been withdrawn succesfully";
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("test").innerHTML=this.responseText;
      document.getElementById("test").style.border="none";
    }
  }
  xmlhttp.open("GET","task.php?q="+q+"&p="+msg+"&r="+r+"&v="+value+"&s="+company_s+"&z="+tid,true);
  xmlhttp.send();
}

function showtasks(str) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("tickets").style.border="0px"
      document.getElementById("tickets").innerHTML=this.responseText;
      document.getElementById("tickets").style.border="none";
    }
  }
  document.getElementById("tickets").innerHTML='<div class="d-flex justify-content-center"><div class="spinner-border text-dark" style="width:10vh;height:10vh;margin-top:35vh;" role="status"><span class="sr-only">Loading...</span></div></div>';
  xmlhttp.open("GET","showtasks.php",true);
  xmlhttp.send();
}
function freview(id,value) {
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("test").innerHTML=this.responseText;
      document.getElementById("test").style.border="none";
      document.getElementById("ticket-"+id).innerHTML = "This task has been reviewed succesfully With a "+value+" star rating";
    }
  }
  xmlhttp.open("GET","review.php?q="+id+"&p="+value,true);
  xmlhttp.send();
}

function updateprofile(){
  b = document.getElementById("myemail").value;
  c = document.getElementById("myprofession").value;
  d = document.getElementById("mymobile").value;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("test").innerHTML=this.responseText;
      document.getElementById("test").style.border="none";
    }
  }
  xmlhttp.open("GET","updateprofile.php?b="+b+"&c="+c+"&d="+d+"&e="+msg,true);
  xmlhttp.send();
}

function foreignprofile(email){
  a = email;
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("foreignprofile").innerHTML=this.responseText;
      document.getElementById("foreignprofile").style.border="none";
    }
  }
  xmlhttp.open("GET","foreignprofile.php?q="+a,true);
  xmlhttp.send();
}

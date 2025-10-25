<?php
  session_start();
  if($_SESSION)
  {
    $id=$_SESSION["id"];
  }


  
    $q=$_GET["id"];
    
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>PAYMENT</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style.css" type="text/css">

<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container1 {
  background-color: #008080;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color: #FF6800;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 30%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
}

.btn:hover {
  background-color: #45a049;
}
.bck
{
  background-image: url("pic.jpg");
  background-repeat: no-repeat;
  background-size: 100% 100%;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}
.header {
  padding: 80px; /* some padding */
  text-align: center; /* center the text */
  background-image: url("https://www.theglobeandmail.com/resizer/NtDW6HpctASDgd1GK9Z0buU9sYA=/3500x0/filters:quality(80)/arc-anglerfish-tgam-prod-tgam.s3.amazonaws.com/public/ZMXGWDNNKRFPTBC4K224VDXJ5U.jpg");
  background-size: 1920px;
  background-repeat: no-repeat;
  background-position: center;
  margin: 0PX;
   color:#;
</style>

<!--</head>
<body class="bck" onload="startTime()">
<div style="width: 550px; float:left; height:550px; background:white; margin:5px;">

  <div style="width: 540px; height: 540px; border: 2px solid black; padding: 0px; margin: 5px;">
  <h1 align="center">Park Easy</h1>
  <p align="center">Parking lot reciept</p>
    <div style="width: 525px; height: 410px; border: 2px solid black; padding: 0px; margin: 5px;">
    <h2 align="center">Entry Time:</h2>
       <p align="center">11:10:14</p>
    <h2 align="center">Exit Time:</h2>
      <div>
        <p id="demo" align="center"></p>
      </div>
    <h2 align="center">Total Price:</h2>
    <p align="center">400.00 INR</p>
    <h2 align="center">Thank You</h2>
    <h3 align="center">Come back soon</h3>
    </div>
  </div>
</div>--><body>
    <div>
           <?php
            require 'header.php';
           ?>
          
             <div class="container">
             </div>
            
           </div>
         </div><br>
<body style="background-color: #FFFFFF";>
<center><div class="row" style="padding-left: 100px;">
  <div class="col-75">
    <div class="container1" style="width: 950px;height: 610px;" align="left">
      <form action="bill.php?id=<?php echo $q ?>" method="post">
          <div class="col-50">
            <center><h1>Payment Gateway</h2></center>
            <center><label for="fname">Accepted Cards</label></center>
            <div class="icon-container">
              <center><i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i></center>
            </div>
            <label for="cname">Enter the Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="Lisa Ray">
            <label for="ccnum">Enter Your Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Expiry Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="December">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Expiry Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvv">Enter card CVV</label>
                <input type="password" id="cvv" name="cvv" placeholder="***">
              </div>
            </div>
          </div><br>
          
        </div>
        <input type="submit" value="BILL GENERATION" class="btn">
      </form>
    </div>
  </div>
</div>
<!---<script>
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
document.getElementById('demo').innerHTML=h+":"+m+":"+s;
</script>--->
</body>
</html>

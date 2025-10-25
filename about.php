<!--?php
session_start();
if($_SESSION)
{
  $id = $_SESSION["id"];
}
else
{
   
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store";


if($_GET)
{
  $q= $_GET["id"];
}else 
{
  $q = "";
}




// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
  


$t =date("h:i:sa");
$d=date("d-m-Y");



$sql="SELECT * FROM checkout WHERE ID ='$q'";
$result = $conn->query($sql);
if ($result->num_rows > 0) 
{  
  while($row = $result->fetch_assoc()) 
    {
        
        $id=$row["ID"];
        $tot=$row["total"];
    }
  }
 
if(!isset($_SESSION['email'])){
        header('location: login.php');
    }
    $user_id=$_SESSION['id'];
    $user_products_query="select it.id,it.name,it.price from users_items ut inner join items it on it.id=ut.item_id where ut.user_id='$user_id'";
    $user_products_result=mysqli_query($conn,$user_products_query) or die(mysqli_error($conn));
    $no_of_user_products= mysqli_num_rows($user_products_result);
    $sum=0;
    if($no_of_user_products==0){
        //echo "Add items to cart first.";


   
    ?>
        <script>
        window.alert("No items in the cart!!");
        </script-->
    <!--?php
    }else{
        while($row=mysqli_fetch_array($user_products_result)){
            $sum=$sum+$row['price']; 
       }
    }
$sn="localhost";
    $un="root";
    $p="";
    $dname="store";
    $conn=new mysqli($sn,$un,$p,$dname);
    $sql="INSERT INTO checkout (ID,total) VALUES ('$user_id',$sum)";
    $result=$conn->query($sql);

?-->

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>ABOUT</title>
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

.container {
  background-color: #202020;
  padding: 0px;
  border: 0px solid lightgrey;
  border-radius: 10px;
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
  width: 86%;
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
   color:#;}
</style>

</head>
<!--body class="bck" onload="startTime()">
<div style="width: 550px; float:left; height:550px; background:white; margin:5px;"><br><br><br><br><br><br-->
  <body>
    <div>
           <?php
            require 'header.php';
           ?>
          
             <div class="container">
             </div>
            
           </div>
         </div><br><br><br>         <style>
          .test2{
      color:black;
      font-size: 18px;
    text-align: justify;
    }
            .test21{
      color:black;
      font-size: 30px;
    text-align: center;
    }
  </style>
         <div id="content">
            <div class="line">
                             
             <strong><u><h1 class="test21">ABOUT US</h1></u><br></strong>

              <p class="test2" >Established in 1952, The Indian Art Gallery is more than a prime art exhibition space. Located in Ramjanki, it has been closely associated with the development of contemporary Indian art.

 The Indian Art Gallery hosts exhibitions by painters,sculptors, print-makers, craftsmen, ceramicists, photographers and weavers. It regularly holds interesting lecture programmes, conducts workshops & discussions on various forms of art, laying stress on education for both the academically inclined and laypersons.

 The Indian Art Gallery has provided a platform for aspiring artists,who have always availed the opportunities provided by the gallery to interact with the art fraternity at various levels.The gallery has continued to be a centre of activity for artists, connoisseurs of art, art-lovers and the public.
               </p>
               <br>
             <strong><u><h1 class="test21">OUR HISTORY</h1></u><br></strong>
               <p class="test2"> The Indian Art Gallery was established in Ramjanki, Mumbai in 1952. It was founded with the help of donations given by Sir Cowasji Jehangir, 2nd Baronet in memory of his late son. B.G. Kher, the then Chief Minister of Bombay, inaugurated the gallery on the 21st of January 1952. The building is designed by Durga Bajpai, and has the distinction of being one of the earliest structures built in the city. It is situated behind the famous Prince of Wales Museum, now known as Chhatrapati Shivaji Maharaj Vastu Sangrahalaya, in the Fort area of Mumbai.
 The Indian Art Gallery has traditionally been one of the most prominent and renowned galleries in India, exhibiting works of artists like M.F. Hussain and S.H. Raza. Other frequenters of the gallery included Akbar Padamsee, Ram Kumar, Anjolie Ela Menon and K.K. Hebbar among others. The surroundings of the gallery can be said to be steeped in rich history and tradition, especially concerning art. The gallery complex houses the Art Plaza Gallery and Natesan, India’s earliest licensed antique dealers.

At present, the building boasts of seven exhibition halls or galleries– the Auditorium Hall, Exhibition Galleries 1, 2, 3 and 4,  The Indian Art Gallery and the Terrace Art Gallery for Photography and Visual Art. The maintenance and management of these is currently undertaken by the Bombay Art Society.

Presently, the gallery hosts over 300 shows annually, one of which is the Monsoon Art Show, held especially for emerging artists. The gallery has therefore always encouraged art, and has also given exposure to hundreds of artists over the years, not only from the city, but from the whole country.
             </p>
            </div>
         </div>

            </div>
         </div>
         <div id="content" class="left-align contact-page">
            <div class="line">
               <div class="margin">
                  <div class="s-12 l-6">
                    <center> <h2>CONTACT US VIA</h2>
                     <address>
                        <p><i class="icon-home icon"></i>3, Ramjanki
356, Linking Road
Khar (West)
Next to Only Parathas Restaurant
Mumbai - 400052</p>
                        <p><i class="icon-globe_black icon"></i> Mumbai-India</p>
                        <p><i class="icon-mail icon"></i> info@indiangallery.com</p>
                     </address>
                     <br />
                     <!--h2>Social</h2>
                     <p><i class="icon-instagram icon"></i> <a href="https://www.facebook.com/pages/Vision-Design-graphic-ZOO/154664684553091">The Indian Art Gallery</a></p><br>
                     <p class="margin-bottom"><i class="icon-twitter icon"></i> <a href="https://twitter.com/MyResponsee">Gallery@Indian</a></p>
                      <p><i class="icon-facebook icon"></i> <a href="https://www.facebook.com/myresponsee">The Indian Art Gallery</a></p-->

                  </div>

                  <br><br><br>
                     <form action="file.php">
  

</form>
   <br>
                 
               </center></div>
                  </div>
               </div>
            </div>
         </div>
         <!-- MAP --> 
         <div id="map-block">     
           
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3770.8635117809317!2d72.83139911490099!3d19.069737687091614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c90e3749f5e3%3A0xa04e66d7ab4f304b!2sRhythm%20Art%20Gallery!5e0!3m2!1sen!2sin!4v1569763904078!5m2!1sen!2sin" width="1500" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
         </div>
         <div id="fourth-block">
            <div class="line">
               <div id="news-carousel" class="owl-carousel owl-theme">
                  <div class="item">
                   
                  </div>
                  
                  
               </div>
            </div>
         </div>
      </section>
<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>INDEX</title>
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
    </head>
    <body>
     <style>
      .test1{
        background-image:url(img/about.jpg); 
      }
    </style>
        <div>
           <?php
            require 'header.php';
           ?>
           <div id="bannerImage">
            <div class="test1">
               <div class="container">
                   <center>
                   <div id="bannerContent">
                    <h1>The Indian Art Gallery.</h1>
                       <p>Get Your Favourite Art Collection At Your Doorstep.</p>
                       <a href="products.php" class="btn btn-danger">View Our Gallery and Shop Now</a>
                   </div>
                   </center>
                 </div>
               </div>
           </div>
           <div class="container">
               <div class="row">
                   <div class="col-xs-4">
                       <div  class="thumbnail">
                           <a href="products.php">
                                <img src="img/pots.jpg" alt="POTRAITS">
                           </a>
                           <center>
                                <div class="caption">
                                        <p id="autoResize">POTRAITS</p>
                                        <p>Best Available potraits.</p>
                                </div>
                           </center>
                       </div>
                   </div>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="products.php">
                               <img src="img/land.jpg" alt="Watch">
                           </a>
                           <center>
                                <div class="caption"><br>
                                    <p id="autoResize">LANDSCAPES</p><br><br>
                                    <p>Original Landscapes.</p>
                                </div>
                           </center>
                       </div>
                   </div>
                   <div class="col-xs-4">
                       <div class="thumbnail">
                           <a href="products.php">
                               <img src="img/abs.jpg" alt="ls">
                           </a>
                           <center>
                               <div class="caption">
                                   <p id="autoResize">ABSTRACT</p>
                                   <p>Our exquisite collection of Abstract art works.</p>
                               </div>
                           </center>
                       </div>
                   </div>
               </div>
           </div>
            <br><br> <br><br><br><br>
           <footer class="footer"> 
               <div class="container">
               <center>
                  <p>Oppurtunity of showing your creative talent at The Indian Art Gallery. SHARE YOUR ART WORK VIA MAIL. OUR EMAIL ID IS-art@artgallery.com </p>
               </center>
               </div>
           </footer>
        </div>

    </body>
</html>
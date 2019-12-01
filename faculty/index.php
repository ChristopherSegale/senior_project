<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>
    <title>Faculty Page</title>
  </head>
  <body>
    <body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

    <div class="jumbotron text-center" style="background-color: transparent">
       <img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
    </div>
    <div class="container" style='background-color: lightgrey; border-radius: 25px; '>
       <div class="row bg-dark text-white" style='border-radius: 25px '>
          <div class="col-mdlg-8" style="padding: 5px">
               <h1>Faculty Page</h1>
               <p><a href="/">Home</a></p>
          </div>
       </div>

    <hr />
    <div class="row">
       <div class="col-lg-8" style="padding: 10px">
         <div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
             <h2><a href="add_fac.php">Create Admin/Moderator</a></h2>
         </div>
         <div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
             <h2><a href="/create_category">Create Category</a></h2>
         </div>
         <div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
             <h2><a href="flagged.php">Show Flagged Posts</a></h2>
         </div>
         <div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
             <h2><a href="ban.php">Ban an IP Address</a></h2>
         </div>
         <div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
    <?php
      if (is_null($_COOKIE['id']) || is_null($_COOKIE['am'])) {
        echo "<h2><a href=\"/login\">Faculty Log in</a></h2>\n";
      }
      else {
        echo "<h2><a href=\"/faculty/logout.php\">Log out</a></h2>\n";
      }
    ?>
   </div>
   </div>
  </body>
</html>

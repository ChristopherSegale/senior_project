<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="styles/bootsrap/js/bootstrap.min.js"></script>
    <title>Log Out</title>
  </head>
  <body>
	<body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

	<div class="jumbotron text-center" style="background-color: transparent">
		<img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
	</div>

	<div class="row">
		<div class="col-lg-8" style="padding: 10px">
			<div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
    <?php
      include "inc_owner_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to database.</p>\n";
      }
      else {
        mysqli_select_db($conn, $database);
	$SQL_string = "DELETE FROM logged_in WHERE id = " . $_COOKIE['id'];
        @mysqli_query($conn, $SQL_string);
        setcookie("am", "", time() - 54000, "/");
        setcookie("id", "", time() - 54000, "/");
        header("location:/faculty");
      }
    ?>
			</div>
		</div>
	</div>
  </body>
</html>

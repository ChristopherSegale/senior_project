<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="styles/bootsrap/js/bootstrap.min.js"></script>
    <title>Ban IP Address</title>
  </head>
  <body>
	<body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

	<div class="jumbotron text-center" style="background-color: transparent">
	<img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
	</div>

	<div class="container" style='background-color: lightgrey; border-radius: 25px; '>
		<div class="row bg-dark text-white" style='border-radius: 25px; '>
			<div class="col-mdlg-8" style-"padding: 5px; ">

    <h1>Ban IP Address</h1>
    <p><a href="/">Home</a> | <a href="/faculty">Faculty</a></p>
    <hr />
			</div>
		</div>
    <?php
      include "verify_fac.php";
      if (is_null($_COOKIE['id'])) {
        echo "<p>You must be be logged in as an admin account to ban users.  Go <a href=\"/login\">here</a> to log in.</p>\n";
      }
      else {
        if (isset($_POST['ban'])) {
	  if (isset($_COOKIE['id']) && verify_admin($_COOKIE['id'])) {
	    include "inc_owner_connect.php";
	    if ($conn === FALSE) {
	      echo "<p>Could not connect to the database.  Try again another time.</p>\n";
	    }
	    else {
	      mysqli_select_db($conn, $database);
	      $SQL_string = "INSERT INTO banned_users (ip_address) VALUES (\"" . $_POST['ip'] . "\")";
	      @mysqli_query($conn, $SQL_string);
	      echo "<p>Added <em>" . $_POST['ip'] . "</em> to list of banned IP addresses.</p>\n";
	    }
	  }
	  else {
	    echo "<p>Could not verify if account is an admin.</p>\n";
	  }
	}
	else {
	  ?>
	<div class="row">
		<div class="col-lg-8" style="padding: 10px">
			<div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
  	  <form action="ban.php" method="post">
	    Enter an IP Address: <input type="text" name="ip" /><br />
	    <input type="submit" name="ban" value="Submit" />
	  </form>
			</div>
		</div>
	  <?php
	}
      }
    ?>
	</div>
	</div>
  </body
</html>

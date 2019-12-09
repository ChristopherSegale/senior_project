<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="styles/bootsrap/js/bootstrap.min.js"></script>
    <title>Delete Post</title>
  </head>
  <body>
	<body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

	<div class="jumbotron text-center" style="background-color: transparent">
		<img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
	</div>

	<div class="container" style='background-color: lightgrey; border-radius: 25px; '>
		<div class="row bg-dark text-white" style='border-radius: 25px; '>
			<div class="col-mdlg-8" style-"padding: 5px; ">

    <h1>Delete Post</h1>
			</div>
		</div>

	<div class="row">
		<div class="col-lg-8" style="padding: 10px">
			<div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
    <?php
      include "inc_admin_connect.php";
      include "verify_fac.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to database.</p>\n";
      }
      else {
	mysqli_select_db($conn, $database);
        $SQL_string = "SELECT name FROM category WHERE id = " . $_POST['cn'];
	$c_query = @mysqli_query($conn, $SQL_string);
	$c_name = mysqli_fetch_row($c_query)[0];
	$SQL_string = "SELECT subject FROM thread WHERE id = " . $_POST['tn'];
	$t_query = @mysqli_query($conn, $SQL_string);
	$t_name = mysqli_fetch_row($t_query)[0];
        echo "<p>\n" . 
	     "<a href=\"/\">Home</a> | " .
	     "<a href=\"/category/index.php/" . $_POST['cn'] . "\">" . $c_name . "</a> | " .
	     "<a href=\"/thread/index.php/" . $_POST['tn'] . "\">" . $t_name . "</a>\n" .
	     "</p>\n" .
	     "<hr />\n";
	if (is_null($_COOKIE['id']) || !verify_mod($_COOKIE['id'])) {
	  echo "<p>User must be logged in as a moderator or administrator to delete posts.</p>\n";
	}
	else {
	  if (!isset($_POST['pn'])) {
	    echo "<p>Post number must be provided to delete a post.</p>\n";
	  }
	  else {
	    $SQL_string = "UPDATE post SET deleted = 'true' WHERE id = " . $_POST['pn'];
	    @mysqli_query($conn, $SQL_string);
	    echo "<p>Post number " . $_POST['pn'] . " has been deleted.</p>\n";
	  }
	}
      }
    ?>
			</div>
		</div>
	</div>
	</div>
  </body>
</html>

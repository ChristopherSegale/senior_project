<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="styles/bootsrap/js/bootstrap.min.js"></script>

    <title>Flagged Posts</title>
  </head>
  <body>
	<body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

	<div class="jumbotron text-center" style="background-color: transparent">
		<img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
	</div>

	<div class="container" style='background-color: lightgrey; border-radius: 25px; '>
		<div class="row bg-dark text-white" style='border-radius: 25px; '>
			<div class="col-mdlg-8" style-"padding: 5px; ">

    <h1>Flagged Posts</h1>
    <p><a href="/">Home</a> | <a href="/faculty">Faculty Page</a></p>
    <hr />
			</div>
		</div>

	<div class="row">
		<div class="col-lg-8" style="padding: 10px">
			<div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>

    <?php
      include "inc_user_connect.php";
      include "verify_fac.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database.  Try again another time.</p>\n";
      }
      else if (is_null($_COOKIE['id']) || !verify_mod($_COOKIE['id'])) {
        echo "<p>Only site faculty can view this page.  Go <a href=\"/login\">here</a> to log in.</p>\n";
      }
      else {
        mysqli_select_db($conn, $database);
	$SQL_string = "SELECT id, thread_id FROM post WHERE flagged = 1 AND deleted = 'false'";
	$flagged = @mysqli_query($conn, $SQL_string);
	while ($row = mysqli_fetch_row($flagged)) {
	  echo "<p><a href=\"/thread/index.php/" . $row[1] . "#" . $row[0] . "\">" . $row[0] . "</a></p>\n<hr />\n";
	}
	mysqli_free_result($flagged);
	echo "<h2>Flagged and Deleted Posts</h2>\n";
	$SQL_string = "SELECT id, thread_id FROM post WHERE flagged = 1 AND deleted = 'true'";
	$flagged = @mysqli_query($conn, $SQL_string);
	while ($row = mysqli_fetch_row($flagged)) {
	  echo "<p><a href=\"/thread/index.php/" . $row[1] . "#" . $row[0] . "\">" . $row[0] . "</a></p>\n<hr />\n";
	}
      }
    ?>
			</div>
		</div>
	</div>
  </body>
</html>

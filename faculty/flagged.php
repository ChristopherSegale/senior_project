<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Faculty Page</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Faculty Page</h1>
    <hr />
    <?php
      include "inc_user_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database.  Try again another time.</p>\n";
      }
      else {
        mysqli_select_db($conn, $database);
	$SQL_string = "SELECT id FROM post WHERE flagged = 1";
	$flagged = @mysqli_query($conn, $SQL_string);
	while ($row = mysqli_fetch_row($flagged)) {
	  echo "<p>" . $row[0] . "</p>\n<hr />\n";
	}
      }
    ?>
  </body>
</html>

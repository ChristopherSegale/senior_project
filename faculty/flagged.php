<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Flagged Posts</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Flagged Posts</h1>
    <p><a href="/">Home</a> | <a href="/faculty">Faculty Page</a></p>
    <hr />
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
  </body>
</html>

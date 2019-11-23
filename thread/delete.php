<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Delete Post</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Delete Post</h1>
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
	    $SQL_string = "DELETE FROM post WHERE id = " . $_POST['pn'];
	    @mysqli_query($conn, $SQL_string);
	    echo "<p>Post number " . $_POST['pn'] . " has been deleted.</p>\n";
	  }
	}
      }
    ?>
  </body>
</html>

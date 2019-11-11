<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Flagging Page</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Flagging Page</h1>
    <hr />
    <?php
      date_default_timezone_set('America/New_York');
      echo "<p>" . date('m/d/Y h:i:s a', time()) . "</p>\n<hr />\n";

      include "inc_user_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database. " . mysqli_error() . "</p>\n";
      }
      else {
	mysqli_select_db($conn, $database);
        $SQL_string = "UPDATE post SET flagged = 1 WHERE id = " . $_POST['pn'];
	mysqli_query($conn, $SQL_string);
	echo "<p>Post number " . $_POST['pn'] . " has been flagged.</p>\n";
      }
    ?>
  </body>
</html>

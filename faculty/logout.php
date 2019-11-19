<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Log Out</title>
  </head>
  <body>
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
  </body>
</html>

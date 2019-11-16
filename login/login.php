<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
  <img src="/images/NetBoard_Logo.png" />
  <h1>Login check</h1>
  <hr />
    <?php
      include "inc_owner_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database.</p>\n";
      }
      else {
        mysqli_select_db($conn, $database);
	$SQL_string = "SELECT password FROM admin_mods WHERE email = \"" . $_POST['email'] . "\"";
	$p_query = @mysqli_query($conn, $SQL_string);
	$hash = mysqli_fetch_row($p_query)[0];
	if (password_verify($_POST['pass'], $hash)) {
	  echo "<p>Logged in successfully.</p>\n";
	}
	else {
	  echo "<p>Login unsuccessful.</p>\n";
	}
      }
    ?>
  </body>
</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Login</title>
  </head>
  <body>
  <img src="/images/NetBoard_Logo.png" />
  <h1>Login check</h1>
  <p><a href="/">Home</a> | <a href="/faculty">Faculty Page</a></p>
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
	$SQL_string = "SELECT email FROM logged_in WHERE email = \"" . $_POST['email'] . "\"";
	$e_query = @mysqli_query($conn, $SQL_string);
	if (mysqli_num_rows($e_query) > 0) {
	  echo "<p>The faculty member with the email <em>" . $_POST['email'] . "</em> is already logged in.</p>\n";
	}
	else if (password_verify($_POST['pass'], $hash)) {
	  $SQL_string = "INSERT INTO logged_in (email, time) VALUES (\"" . $_POST['email'] . "\", NOW())";
	  @mysqli_query($conn, $SQL_string);
	  $SQL_string = "SELECT logged_in.id, admin_mods.admin_or_mod " .
	                "FROM logged_in INNER JOIN admin_mods USING(email) " .
			"WHERE email = \"" . $_POST['email'] . "\"";
	  $f_query = @mysqli_query($conn, $SQL_string);
	  $fac = mysqli_fetch_row($f_query);
	  setcookie("id", $fac[0], time() + 54000, "/");
	  setcookie("am", $fac[1], time() + 54000, "/");
	  echo "<p>Login successful.</p>\n";
	  header("location:/faculty");
	}
	else {
	  echo "<p>Login unsuccessful.</p>\n";
	}
        mysqli_close($conn);
      }
    ?>
  </body>
</html>

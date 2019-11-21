<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Add Faculty</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Add a new Faculty Member</h1>
    <hr />
    <p><a href="/">Home</a> | <a href="/faculty">Faculty Page</a></p>
    <?php
      include "verify_fac.php";
      if (isset($_POST['inc_fac'])) {
        $email = $_POST['email'];
	$pass = $_POST['pass'];
	$aom = $_POST['aom'];

	if (!verify_admin($_COOKIE['id'])) {
	  echo "<p>User must be logged in under an administrator account to add a faculty member.</p>\n" .
	       "<p>Go <a href=\"/login\">here</a> to log in.</p>\n";
	}
	else if (strcmp($email, "") === 0) {
	  echo "<p>Email field must be filled</p>\n" .
	       "<p>Go <a href=\"add_fac.php\">back</a> to enter the value into the input field.</p>\n";
	}
	else {
	  if (strcmp($pass, "") === 0) {
	    echo "<p>Password field must be filled</p>\n" .
	         "<p>Go <a href=\"add_fac.php\">back</a> to enter the value into the input field.</p>\n";
	  }
	  else {
	    include "inc_admin_connect.php";
	    if ($conn === FALSE) {
	      echo "<p>Could not connect to the database. " . mysqli_error() . "</p>\n" .
	           "<p>Go <a href=\"add_fac.php\">back</a> and try again when the server is back up.</p>\n";
	    }
	    else {
	      $sql_string = "INSERT INTO admin_mods (email, password, admin_or_mod) VALUES " .
	                    "(\"" . $email . "\", \"" . password_hash($pass, PASSWORD_DEFAULT) . "\", \"" . $aom . "\")";
	      mysqli_select_db($conn, $database);
	      @mysqli_query($conn, $sql_string);
	      echo "<p>Faculty member added to database.</p>\n";
	    }
	  }
	}
      }
      else {
        ?>
	<form action="add_fac.php" method="post">
	  <p>
	    <select name="aom">
	      <option value="admin">Administrator</option>
	      <option value="mod">Moderator</option>
	    </select><br />
	    Email Address: <input type="text" name="email" /><br />
	    Password: <input type="password" name="pass" />
	  </p>
	  <input type="submit" name="inc_fac" value="Submit" />
	</form>
	<?php
      }
    ?>
  </body>
</html>

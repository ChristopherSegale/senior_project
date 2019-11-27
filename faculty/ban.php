<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Ban IP Address</title>
  </head>
  <body>
  <img src="/images/NetBoard_Logo.png" />
    <h1>Ban IP Address</h1>
    <p><a href="/">Home</a> | <a href="/faculty">Faculty</a></p>
    <hr />
    <?php
      include "verify_fac.php";
      if (is_null($_COOKIE['id'])) {
        echo "<p>You must be be logged in as an admin account to ban users.  Go <a href=\"/login\">here</a> to log in.</p>\n";
      }
      else {
        if (isset($_POST['ban'])) {
	  if (isset($_COOKIE['id']) && verify_admin($_COOKIE['id'])) {
	    include "inc_owner_connect.php";
	    if ($conn === FALSE) {
	      echo "<p>Could not connect to the database.  Try again another time.</p>\n";
	    }
	    else {
	      mysqli_select_db($conn, $database);
	      $SQL_string = "INSERT INTO banned_users (ip_address) VALUES (\"" . $_POST['ip'] . "\")";
	      @mysqli_query($conn, $SQL_string);
	      echo "<p>Added <em>" . $_POST['ip'] . "</em> to list of banned IP addresses.</p>\n";
	    }
	  }
	  else {
	    echo "<p>Could not verify if account is an admin.</p>\n";
	  }
	}
	else {
	  ?>
	  <form action="ban.php" method="post">
	    Enter an IP Address: <input type="text" name="ip" /><br />
	    <input type="submit" name="ban" value="Submit" />
	  </form>
	  <?php
	}
      }
    ?>
  </body
</html>

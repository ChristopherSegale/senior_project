<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Insert Category</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <p><a href="/">Home</a> | <a href="/faculty">Faculty Page</a></p>
    <hr />
    <?php
      include "verify_fac.php";
      if (isset($_POST['insert_category'])) {
        if (is_null($_COOKIE['id']) || !verify_admin($_COOKIE['id'])) {
	  echo "<p>User must be logged in under an administrator account to add a category.</p>\n" .
	       "<p>Go <a href=\"/login\">back</a> to log in.</p>\n";
	}
	else if (strcmp($_POST['name'], "")  === 0 || strcmp($_POST['description'], "") === 0) {
	  echo "<p>Form has not been fully submitted. Go back to the form creation " .
	       "<a href=\"http://" . $_SERVER['HTTP_HOST'] . "/create_category/index.html\">" .
               "page</a> and fully enter all fields.</p>\n";
	}
	else {
	  include "inc_admin_connect.php";
	  if ($conn === FALSE) {
	    echo "<p>Could not connect to the database. " . mysqli_error(). "</p>\n" .
	         "<p>Try inserting data again when the database is available.</p>\n";
	  }
	  else {
	    mysqli_select_db($conn, $database);
	    $insert = "INSERT INTO category " .
	              "(name, description, created) " .
		      "VALUES " .
		      "(\"" . $_POST['name'] . "\", \"" . $_POST['description'] . "\", NOW())";
	    // echo "<p>" . $insert . "</p>\n";
	    @mysqli_query($conn, $insert);
	    echo "<p>Category has been submitted to the database.</p>\n";
	  }
	}
      }
      else {
        echo "<p>Category has not been submitted to the database.</p>\n";
      }
    ?>
  </body>
</html>

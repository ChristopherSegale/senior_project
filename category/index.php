<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <?php
      $db_connect = TRUE;
      $category = "Category";
      $cat_id = str_replace("/category/", "", $_SERVER['REQUEST_URI']);
      include "inc_user_connect.php";
      if ($conn === FALSE) {
        $db_connect = FALSE;
      }

      if ($db_connect && strcmp($cat_id, "") !== 0) {
        mysqli_select_db($conn, $database);
	$n = @mysqli_query($conn, "SELECT name FROM category where id = " . $cat_id);
	$category = mysqli_fetch_row($n)[0];
      }
      
      echo "<title>" . $category . "</title>\n";
    ?>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Category Page</h1>
    <hr />
    <?php
      date_default_timezone_set('America/New_York');
      echo "<p>" . date('m/d/Y h:i:s a', time()) . "</p>\n";
      if (strcmp($cat_id, "") == 0) {
        echo "<p>Category id must be supplied in the uri.</p>\n";
      }
      else if ($db_connect) {
        echo "<hr />\n<h2>Threads</h2>\n<hr />\n";
	mysqli_select_db($conn, $database);
	$subjects = @mysqli_query($conn, "SELECT subject FROM thread WHERE category.id = " . $cat_id);

	while ($row = mysqli_fetch_row($subjects)) {
	  echo "<hr />\n<h3>" . $row . "</h3>\n";
	}

	mysqli_close($conn);
      }
    ?>
  </body>
</html>

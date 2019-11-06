<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <?php
      $db_connect = TRUE;
      $category = "Category";
      $cat_id = str_replace("/category/index.php/", "", $_SERVER['REQUEST_URI']);
      include "inc_user_connect.php";
      if ($conn === FALSE) {
        $db_connect = FALSE;
      }

      if ($db_connect && strcmp($cat_id, "") !== 0) {
        mysqli_select_db($conn, $database);
	$c_query = "SELECT name FROM category WHERE id = " . $cat_id;
	$n = @mysqli_query($conn, $c_query);
	$category = mysqli_fetch_row($n)[0];
      }
      
      echo "<title>" . $category . "</title>\n";
    ?>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <?php echo "<h1>" . $category . "</h1>\n"; ?>
    <hr />
    <?php
      date_default_timezone_set('America/New_York');
      echo "<p>" . date('m/d/Y h:i:s a', time()) . "</p>\n";
      echo "<a href=\"/\">Home</a>\n";
      if (strcmp($cat_id, "") == 0) {
        echo "<p>Category id must be supplied in the uri.</p>\n";
      }
      else if ($db_connect) {
        echo "<hr />\n<h2>Threads</h2>\n";
	mysqli_select_db($conn, $database);
	$SQL_string = "SELECT thread.subject, thread.id " .
	              "FROM thread INNER JOIN category ON thread.category_id = category.id " . 
		      "WHERE thread.category_id = " . $cat_id;
	$subjects = @mysqli_query($conn, $SQL_string);

	while ($row = mysqli_fetch_row($subjects)) {
	  echo "<hr />\n<h3><a href=\"/thread/index.php/" . $row[1] . "\">" . $row[0] . "</a></h3>\n";
	}

	mysqli_close($conn);
	?>
	<hr />
	<h3>Insert New Thread</h3>
	<form action="/category/insert_thread.php" method="post">
	  <p>
	    Thread Title: <input type="text" name="title" /><br />
	    Original Post Body: <br />
	    <textarea rows="5" cols="80" name="op"></textarea>
	  </p>
	  <input type="hidden" name="cat" value="<?php echo "$cat_id"; ?>" />
	  <input type="submit" name="insert_thread" value="Submit" />
	</form>
	<?php
      }
    ?>
  </body>
</html>

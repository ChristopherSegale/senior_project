<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <?php
      include "inc_user_connect.php";

      $db_connect = TRUE;
      $thread = "Placeholder Title";
      $thread_id = str_replace("/thread/index.php/", "", $_SERVER['REQUEST_URI']);
      $cat_id = "";
      $cat = "";
      if ($conn === FALSE) {
        $db_connect = FALSE;
      }
      if ($db_connect && strcmp($thread_id, "") !== 0) {
        mysqli_select_db($conn, $database);
	$t_query = "SELECT subject, category_id FROM thread WHERE id = " . $thread_id;
	$r = @mysqli_query($conn, $t_query);
	$t = mysqli_fetch_row($r);
	$thread = $t[0];
	$cat_id = $t[1];
	$c = @mysqli_query($conn, "SELECT name FROM category WHERE id = " . $cat_id);
	$cat = mysqli_fetch_row($c)[0];
      }
      echo "<title>" . $thread . "</title>\n";
    ?>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1><?php echo $thread; ?></h1>
    <hr />
    <?php
      date_default_timezone_set('America/New_York');
      echo "<p>" . date('m/d/Y h:i:s a', time()) . "</p>\n";
      echo "<a href=\"/\">Home</a> | <a href=\"/category/index.php/" . $cat_id . "\">" . $cat . "</a>\n";
      if (strcmp($thread_id, "") === 0) {
        echo "<p>Thread id must be supplied in the uri.</p>\n";
      }
      else if ($db_connect) {
        $SQL_string = "SELECT post.id, post.tripcode, post.created, post.deleted, post.content " .
	              "FROM post INNER JOIN thread ON post.thread_id = thread.id " .
		      "WHERE post.thread_id = " . $thread_id;
        $tr = @mysqli_query($conn, $SQL_string);

	while ($row = mysqli_fetch_row($tr)) {
	  if (strcmp($row[3], "false") === 0) {
	    $trip = "Anonymous";
	    if (!(is_null($row[1]))) {
	      $trip = $row[1];
	    }

	    echo "<p>\n" .
	         $row[0] . "<br />\n" .
		 $row[2] . "<br />\n" .
	         $trip . "<br />\n";
	    $pb = nl2br($row[4]);
	    echo $pb;
	    echo "\n</p>\n<hr />\n";
	  }
	}
	mysqli_close($conn);
	?>
	<h3>Insert New Post</h3>
	<form action="/thread/insert_post.php" method="post">
	  <p>
	    Tripcode: <input type="text" name="trip" /> <br />
	    Post Body: <br />
	    <textarea rows="5" cols="80" name="pb"></textarea>
	  </p>
	  <input type="hidden" name="tc" value="<?php echo $thread_id; ?>" />
	  <input type="hidden" name="tt" value="<?php echo $thread; ?>" />
	  <input type="submit" name="insert_post" value="Submit" />
	</form>
	<?php
      }
      else {
        echo "<p>Could not connect to the database. Try again another time.</p>\n";
      }
    ?>
  </body>
</html>

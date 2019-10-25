<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Insert Thread</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Insert Thread</h1>
    <hr />
    <?php
      include "inc_user_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to database.  Try again another time</p>\n";
      }
      else {
        if (isset($_POST['insert_thread'])) {
	  if (strcmp($_POST['title'], "") === 0) {
	    echo "<p>Title is required to post thread.</p>\n";
	  }
	  else if (strcmp($_POST['op'], "") === 0) {
	    echo "<p>Post body must be filled in to post thread.</p>\n";
	  }
	  else {
	    mysqli_select_db($conn, $database);
	    $thread_insert = "INSERT INTO thread (subject, created, category_id) VALUES " .
	                     "(\"" . $_POST['title'] . "\", NOW(), " . $_POST['cat_id'] . ")";
	    @mysqli_query($conn, $thread_insert);
	    $thread_row = @mysqli_query($conn, "SELECT id WHERE title = \"" . $_POST['title'] . "\"");
	    $thread_id = @mysqli_fetch_row($thread_row)[0];
	    $op_insert = "INSERT INTO post (content, created, thread_id, ip_address) VALUES " .
	                 "(\" . $_POST['op'] . "\", NOW(), " . $thread_id . ", \" . $_SERVER['REMOTE_ADDR'] . "\")";
	    @mysqli_query($conn, $op_insert);
	  }
	}
	mysqli_close($conn);
      }
    ?>
  </body>
</html>

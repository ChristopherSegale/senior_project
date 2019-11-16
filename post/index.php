<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Post Redirction</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Post Redirection</h1>
    <hr />
    <?php
      include "inc_user_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database.</p>\n";
      }
      else {
        $post_id = str_replace("/post/index.php/", "", $_SERVER['REQUEST_URI']);
        $thread_id = "";
	if (strcmp($post_id, "") !== 0) {
	  mysqli_select_db($conn, $database);
	  $t_query = "SELECT thread_id FROM post WHERE id = " . $post_id;
	  $p_query = @mysqli_query($conn, $t_query);
	  $thread_id = mysqli_fetch_row($p_query)[0];
	  header("location:/thread/index.php/" . $thread_id . "#" . $post_id);
	}
      }
    ?>
  </body>
</html>

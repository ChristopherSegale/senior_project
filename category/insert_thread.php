<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Insert Thread</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Insert Thread</h1>
    <hr />
    <p><a href="/">Home</a></p>
    <?php
      include "inc_user_connect.php";
      include "verify_fac.php";
      include "check_ban.php";
      include "priv_cat.php";

      function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
          //ip from share internet
          $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
          //ip pass from proxy
          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
          $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
      }

      function tripcode($name)
      {
        $salt_file = "/var/www/html/thread/salt.txt";
        $file = fopen($salt_file, "r");
        $salt = fread($file, filesize($salt_file));
        fclose($file);
        return crypt($name, $salt);
      }

      if ($conn === FALSE) {
        echo "<p>Could not connect to database.  Try again another time</p>\n";
      }
      else {
	if (!isset($_POST['insert_thread'])) {
	  echo "<p>Thread submission form must be sent in order to insert thread.</p>\n";
	}
	else if (is_banned(get_ip())) {
	  echo "<p>The ip address associated with this device is banned from posting</p>\n";
	}
	else if (priv_cat($_POST['cat']) && (is_null($_COOKIE['id']) || !verify_admin($_COOKIE['id']))) {
	  echo "<p>User must be an admin to make threads in this category.</p>\n";
	}
        else {
	  if (strcmp($_POST['title'], "") === 0) {
	    echo "<p>Title is required to post thread.</p>\n";
	  }
	  else if (strcmp($_POST['op'], "") === 0) {
	    echo "<p>Post body must be filled in to post thread.</p>\n";
	  }
	  else {
	    mysqli_select_db($conn, $database);
	    $IP = get_ip();
	    $trip = "";
	    if (isset($_COOKIE['id']) && verify_mod($_COOKIE['id'])) {
	      $trip = $_COOKIE['am'];
	    }
	    else if (strcmp($_POST['trip'], "") !== 0) {
	      $trip = tripcode($_POST['trip']);
	    }
	    $thread_insert = "INSERT INTO thread (subject, created, category_id) VALUES " .
	                     "(\"" . $_POST['title'] . "\", NOW(), " . $_POST['cat'] . ")";
	    @mysqli_query($conn, $thread_insert);
	    $SQL_title = "SELECT id FROM thread WHERE subject = \"" . $_POST['title'] . "\"";
	    $thread_row = @mysqli_query($conn, $SQL_title);
	    $thread_id = @mysqli_fetch_row($thread_row)[0];
	    $op = mysqli_escape_string($conn, $_POST['op']);
	    if (strcmp($trip, "") === 0) {
	      $op_insert = "INSERT INTO post (content, created, thread_id, ip_address) VALUES " .
	                   "(\"" . $op . "\", NOW(), " . $thread_id . ", \"" . $IP . "\")";
	    }
	    else {
	      $op_insert = "INSERT INTO post (content, created, thread_id, ip_address, tripcode) VALUES " .
	                   "(\"" . $op . "\", NOW(), " . $thread_id . ", \"" . $IP . "\", \"" . $trip . "\")";
	    }
	    @mysqli_query($conn, $op_insert);
	    echo "<p>Thread <em>" . $_POST['title'] . "</em> has been inserted into the database.</p>\n" .
	         "<p>Go to <a href=\"/thread/index.php/" . $thread_id . "\">your thread</a> to look at your submission.</p>\n";
	    /* Print SQL queries for debug purposes */
	    //echo "<p>" . $SQL_title . "</p>\n";
	    //echo "<p>" . $thread_insert . "</p>\n<p>" . $op_insert . "</p>\n";
	    header("location:/thread/index.php/" . $thread_id);
	  }
	}
	mysqli_close($conn);
      }
    ?>
  </body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Post Insertion</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Post Insertion Page</h1>
    <hr />
    <?php
      include "inc_user_connect.php";
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
        $salt_file = "salt.txt";
        $file = fopen($salt_file, "r");
        $salt = fread($file, filesize($salt_file));
        fclose($file);
        return crypt($name, $salt);
      }

      date_default_timezone_set('America/New_York');
      echo "<p>" . date('m/d/Y h:i:s a', time()) . "</p>\n";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database. Try again another time.</p>\n";
      }
      else if (!(isset($_POST['insert_post']))) {
        echo "<p>Post form must be submitted to insert post.</p>\n";
      }
      else {
        mysqli_select_db($conn, $database);

	if (strcmp($_POST['pb'], "") === 0) {
	  echo "<p>Post body must be filled in order to insert post.</p>\n";
	}
	else {
	  $pb = mysqli_escape_string($conn, $_POST['pb']);
	  $IP = get_ip();
	  $SQL_string = "";
	  if (strcmp($_POST['trip'], "") === 0 && is_null($_COOKIE['am'])) {
	    $SQL_string = "INSERT INTO post (content, created, thread_id, ip_address) VALUES " .
	                  "(\"" . $pb . "\", NOW(), " . $_POST['tc'] . ", \"" . $IP . "\")";
	  }
	  else if (isset($_COOKIE['am'])) {
	    $trip = $_COOKIE['am'];
	    $SQL_string = "INSERT INTO post (content, created, tripcode, thread_id, ip_address) VALUES " .
	                  "(\"" . $pb . "\", NOW(), \"" . $trip . "\", " . $_POST['tc'] . ", \"" . $IP . "\")";
	  }
	  else {
	    $trip = mysqli_escape_string($conn, tripcode($_POST['trip']));
	    $SQL_string = "INSERT INTO post (content, created, tripcode, thread_id, ip_address) VALUES " .
	                  "(\"" . $pb . "\", NOW(), \"" . $trip . "\", " . $_POST['tc'] . ", \"" . $IP . "\")";
	  }
	  @mysqli_query($conn, $SQL_string);
	  echo "<p>Post has been submitted to the <em>" . $_POST['tt'] . "</em> thread. <br />\n" .
	       "Go <a href=\"/thread/index.php/" . $_POST['tc'] . "\">here</a> to return to thread.</p>\n";
	  header("location:/thread/index.php/" . $_POST['tc']);
	}
      }
    ?>
  </body>
</html>

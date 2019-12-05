<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">

	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>

    <?php
      include "inc_user_connect.php";
      include "verify_fac.php";

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
    <body style ="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

    <div class="jumbotron text-center" style = "background-color: transparent">
        <img class="img-fluid" src="/images/NetBoard_Logo2.png" />
    </div>

	<div class="container"  style ='background-color: lightgray; border-radius: 25px; '>
        <div class="row bg-dark text-white" style=" border-radius: 25px">
            <div class="col-mdlg-8" style="padding: 5px"">
		<?php    echo "<p> <a href=\"/\">Home</a> / <a href=\"/category/index.php/" . $cat_id . "\">" . $cat . "</a> / $thread <p>"; ?>
			<?php
                     	date_default_timezone_set('America/New_York');
                        echo "<p>" . date('m/d/Y h:i:s a', time()) . " </p>";?>
	    </div>
        </div>
<div class="row">
           <div class="col-lg-8" style="padding: 10px"> 
    <?php

      echo "<h1>" . $thread . "</h1>\n";
      echo "</div>\n</div>\n";

      if (strcmp($thread_id, "") === 0) {
        echo "<p>Thread id must be supplied in the uri.</p>\n";
      }
      else if ($db_connect) {
        $SQL_string = "SELECT post.id, post.tripcode, post.created, post.deleted, post.content, post.ip_address " .
	              "FROM post INNER JOIN thread ON post.thread_id = thread.id " .
		      "WHERE post.thread_id = " . $thread_id;
        $tr = @mysqli_query($conn, $SQL_string);

	while ($row = mysqli_fetch_row($tr)) {
	  if ((isset($_COOKIE['id']) && verify_mod($_COOKIE['id'])) || strcmp($row[3], "false") === 0) {
	    $trip = "Anonymous";
	    if (!(is_null($row[1]))) {
	      $trip = $row[1];
	    }

	    $ip = "";
	    $del = "";
	    if (isset($_COOKIE['am']) && strcmp($row[3], "false") === 0) {
	      $ip = $row[5] . "<br />\n";
	      $del = "<form action=\"/thread/delete.php\" method=\"post\">\n" .
	             "<input type=\"hidden\" name=\"pn\" value=\"" . $row[0] . "\" />\n" .
		     "<input type=\"hidden\" name=\"tn\" value=\"" . $thread_id . "\" />\n" .
		     "<input type=\"hidden\" name=\"cn\" value=\"" . $cat_id . "\" />\n" .
		     "<input type=\"submit\" value=\"Delete\" />\n" .
		     "</form><br />\n";
	    }
	    else if (isset($_COOKIE['am']) && strcmp($row[3], "true") === 0) {
	      $ip = $row[5] . "<br />\n";
	      $del = "<strong>Deleted Post</strong><br /><br />\n";
	    }

	echo " <div class='row-center' style='border:1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>\n";

	
	echo "<p> Post: ".$row[0] . "</p>\n";
	if (strcmp ($ip, "") !== 0) {
	  echo "<p> IP Address: " . $ip . "</p>\n";
	}
	echo "<p> Date: " . $row[2] . "</p>";
	echo "<p> User: " . $trip . "</p>\n<hr>\n";
	$pb = nl2br(htmlentities($row[4], ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        echo $pb;


	
	?>
	<hr><br>
	<form action="/thread/flag.php" method="post">
	  <input type="hidden" name="pn" value="<?php echo $row[0]; ?>" />
	  <input type="submit" value="flag" />
	</form>
	<br >
	<?php
	echo $del;
	echo "</div>\n<br>\n";



	  }
	}
	mysqli_close($conn);
	?>



         <hr >
	 <div class='row-center' style='border:1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
	 <button id="NewPostButton" onclick="ShowNewPostForm()">New Post</button>
         <div id="NewPostForm" style="display:none; align-self: center; background: ">


	<h3>Insert New Post</h3>
	<form action="/thread/insert_post.php" method="post">
	  <p>
	    <?php
	      if (is_null($_COOKIE['am'])) {
	        echo "Tripcode: <input type=\"text\" name=\"trip\" /> <br />\n";
              }
	    ?>
	    Post Body: <br />
	    <textarea rows="5" cols="80" name="pb"></textarea>
	  </p>
	  <input type="hidden" name="tc" value="<?php echo $thread_id; ?>" />
	  <input type="hidden" name="tt" value="<?php echo $thread; ?>" />
	  <input type="submit" name="insert_post" value="Submit" />
	</form>

	<br>
	 
	</form>

</div>
	</div>
<script>
                function ShowNewPostForm() {
                    var x = document.getElementById("NewPostForm");
                    x.style.display = "block";
                     
                    var y = document.getElementById("NewPostButton");
                    y.style.display = "none";
                }           
            </script>
	<?php
      }
      else {
        echo "<p>Could not connect to the database. Try again another time.</p>\n";
      }
    ?>
	<br>
	</div>
        </div> 
        <br>
         </div>
  </body>
</html>

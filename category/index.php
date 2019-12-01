<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
    <script src="styles/bootstrap/js/bootstrap.min.js"></script>

    <?php
      include "verify_fac.php";
      function is_thread_del($c, $i) {
        $del = FALSE;
        $s = "SELECT deleted FROM post WHERE thread_id = " . $i;
	$q = @mysqli_query($c, $s);
	$r = mysqli_fetch_row($q)[0];
	if (strcmp($r, "true") === 0) {
	  $del = TRUE;
	}
	return $del;
      }

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
  <body style ="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">


    <div class="jumbotron text-center" style = "background-color: transparent">
        <img class="img-fluid" src="/images/NetBoard_Logo2.png" />
    </div>

    <div class="container"  style ='background-color: lightgray; border-radius: 25px; '>
        <div class="row bg-dark text-white" style=" border-radius: 25px">
                <div class="col-mdlg-8" style="padding: 5px"">
                	<?php echo "<p>  <a href=\"/\">Home </a> / " . $category . "</p>"; ?>
			<?php
                     	date_default_timezone_set('America/New_York');
                        echo"<p>" . date('m/d/Y h:i:s a', time()) ." </p>";?>
		
		</div>
        </div> 


	<div class="row">
           <div class="col-lg-8" style="padding: 10px"> 

    		<?php echo "<h1>" . $category . " Related Threads</h1>\n"; ?>
   
    <?php
	  if (strcmp($cat_id, "") == 0) {
        echo "<p>Category id must be supplied in the uri.</p>\n";
      }
      else if ($db_connect) {
        
	mysqli_select_db($conn, $database);
	$SQL_string = "SELECT thread.subject, thread.id " .
	              "FROM thread INNER JOIN category ON thread.category_id = category.id " . 
		      "WHERE thread.category_id = " . $cat_id;
	$subjects = @mysqli_query($conn, $SQL_string);
	
	

	while ($row = mysqli_fetch_row($subjects)) {
	  if (!is_thread_del($conn, $row[1])) {
	echo" <div class='row-center' style='border:1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>";

	    echo "<h3><a href=\"/thread/index.php/" . $row[1] . "\">" . $row[0] . "</a></h3>";

	   echo"</div>";
		echo"<br>";
	  }
	  else if (is_thread_del($conn, $row[1]) && (isset($_COOKIE['id']) && verify_mod($_COOKIE['id']))) {
	    echo "<hr >\n<h3><a href=\"/thread/index.php/" . $row[1] . "\">" . $row[0] . " (deleted)</a></h3>\n";
	  }
	}


	mysqli_close($conn);
	
	$trip = "";
	if (is_null($_COOKIE['id'])) {
	  $trip = "Tripcode: <input type=\"text\" name=\"trip\" /><br />\n";
	}
	?>



	  
	<hr >

	 <div class='row-center' style='border:1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>

	 <button id="NewPostButton" onclick="ShowNewPostForm()">New Post</button>
         <div id="NewPostForm" style="display:none; align-self: center; background: ">

	<h3>Insert New Thread</h3>
	<form action="/category/insert_thread.php" method="post">

	<?php echo $trip; ?>

	<p style="margin-bottom: 5px" >Thread Title: </p>
	<p> <input  style="width: 60%" type="text" name="title" /> </p>
	
	<p style-"margin-bottom: 5px" > Post Body:<p/>
	 <textarea class="form-control-middle" rows="5" name="op"  style="width: 60%"></textarea>

	<br>

	  <input type="hidden" name="cat" value="<?php echo "$cat_id"; ?>" />
	  <input type="submit" name="insert_thread" value="Submit" />
	</form>
	<?php
      }
    ?>
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
</div>
  </body>
</html>

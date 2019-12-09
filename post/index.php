<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">
	<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script src="styles/bootsrap/js/bootstrap.min.js"></script>
    <title>Post Redirection</title>
  </head>
  <body>
	<body style="background-image: url('../../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

	<div class="jumbotron text-center" style="background-color: transparent">
		<img class="img-fluid" src="../../images/NetBoard_Logo2.png" />
	</div>

	<div class="container" style='background-color: lightgrey; border-radius: 25px; '>
		<div class="row bg-dark text-white" style='border-radius: 25px; '>
			<div class="col-mdlg-8" style-"padding: 5px; ">
    <h1>Post Redirection</h1>
    <hr />
			</div>
		</div>

	<div class="row">
		<div class="col-lg-8" style="padding: 10px">
			<div class='row-center' style='border: 1px solid black; border-radius: 15px; background-color: white; width: 100%; padding: 10px'>
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
			</div>
		</div>
	</div>
	</div>
  </body>
</html>

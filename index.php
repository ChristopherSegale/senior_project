<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>

    <title>Preliminary Anonymous Board</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css ">

  </head>
   <body style ="background-image: url('../images/IndexBackground.png'); background-repeat: no-repeat; background-attachment: fixed; background-size: 100% 100%">

    <div class="jumbotron text-center" style = "background-color: transparent">
        <img class="img-fluid" src="/images/NetBoard_Logo2.png" />
    </div>


    <?php
      date_default_timezone_set('America/New_York');

      include "inc_user_connect.php";
      if ($conn === FALSE) {
        echo "<p>Could not connect to the database. " . mysqli_error() . "</p>\n";
      }
      else {
	echo"<div class='container'  style ='background-color: lightgray; border-radius: 25px; '>";
	echo"	<div class='row'>";
	echo" 		<div class='col-md-6' style='padding: 10px'> ";
	echo"			<p>".date('m/d/Y h:i:s a', time() )."</p>";
	echo"			<h1>Categories</h1>";
	echo"		</div>";
	echo"	</div>";
	echo"	<br>";

	mysqli_select_db($conn, $database);
	$categories= @mysqli_query($conn, "SELECT id, name, description FROM category");

	while ($row = mysqli_fetch_row($categories)) {

	echo" <div class='row-center' style='border:1px solid black; border-radius: 15px; background-color: white;  width: 85%; padding: 10px'>";
	         echo"<dl>";

                   echo "<dt>";
			echo "<h3><a href=\"/category/index.php/" . $row[0] . "\">" . $row[1] . "</a></h3>\n";
		   echo"</dt>";
                   echo "<dd>";
			echo "<p>" . $row[2] . "</p>\n";

		   echo"</dd>";

                 echo"</dl>";
        
       	echo"</div>";
	echo"<br>";
	
	 
	}

	echo"</div>";
	mysqli_close($conn);
      }
    ?>
    <hr />

    <div class=container>
        <div class="col-sm-6" style="padding: 10px">
            <a href="/faculty/index.php" class="btn btn-primary">Faculty Page</a>
        </div>
    </div>
 
  </body>
</html>

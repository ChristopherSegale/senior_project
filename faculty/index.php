<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>Faculty Page</title>
  </head>
  <body>
    <img src="/images/NetBoard_Logo.png" />
    <h1>Faculty Page</h1>
    <hr />
    <?php
      echo "<h2><a href=\"add_fac.php\">Create Admin/Moderator</a></h2>\n";
      echo "<h2><a href=\"flagged.php\">Show Flagged Posts</a></h2>\n";
      if (is_null($_COOKIE['id']) || is_null($_COOKIE['am'])) {
        echo "<h2><a href=\"/login\">Faculty Log in</a></h2>\n";
      }
      else {
        echo "<h2><a href=\"/faculty/logout.php\">Log out</a></h2>\n";
      }
    ?>
  </body>
</html>

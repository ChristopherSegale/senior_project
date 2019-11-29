<?php
  function priv_cat($i) {
    include "inc_user_connect.php";
    $is_priv = FALSE;
    mysqli_select_db($conn, $database);
    $SQL_string = "SELECT name FROM category WHERE id = " . $i;
    $q = @mysqli_query($conn, $SQL_string);
    $r = mysqli_fetch_row($q);
    $n = $r[0];
    if (strcmp($n, "Administration") === 0 || strcmp($n, "User Guide") === 0) {
      $is_priv = TRUE;
    }
    return $is_priv;
  }
?>

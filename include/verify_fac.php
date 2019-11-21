<?php
  function verify_admin($i) {
    include "inc_owner_connect.php";
    $is_admin = TRUE;
    $f = "";
    $SQL_string = "SELECT admin_mods.admin_or_mod " .
                  "FROM logged_in INNER JOIN admin_mods USING(email) " .
		  "WHERE logged_in.id = " . $i;
    $r = @mysqli_query($conn, $SQL_string);
    if (mysqli_num_rows($r) === 0) {
      $is_admin = FALSE;
    }
    else {
      $f = mysqli_fetch_row($r)[0];
      if (strcmp($f, "admin") !== 0) {
        $is_admin = FALSE;
      }
    }
    mysqli_close($conn);
    return $is_admin;
  }

  function verify_mod($i) {
    include "inc_owner_connect.php";
    $is_mod = TRUE;
    $f = "";
    $SQL_string = "SELECT admin_mods.admin_or_mod " .
                  "FROM logged_in INNER JOIN admin_mods USING(email) " .
		  "WHERE logged_in.id = " . $i;
    $r = @mysqli_query($conn, $SQL_string);
    if (mysqli_num_rows($r) === 0) {
      $is_mod = FALSE;
    }
    else {
      $f = mysqli_fetch_row($r)[0];
      if ((strcmp($f, "admin") !== 0) || (strcmp($f, "mod") !== 0)) {
        $is_admin = FALSE;
      }
    }
    mysqli_close($conn);
    return $is_mod;
  }
?>

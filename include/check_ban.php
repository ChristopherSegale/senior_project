<?php
  function is_banned($ip) {
    include "inc_owner_connect.php";
    mysqli_select_db($conn, $database);
    $banned = FALSE;
    $SQL_string = "SELECT id FROM banned_users WHERE ip_address = '" . $ip . "'";
    $q = @mysqli_query($conn, $SQL_string);
    if (mysqli_num_rows($q) > 0) {
      $banned = TRUE;
    }
    return $banned;
  }
?>

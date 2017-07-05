<?php

//===== LOGOUT (END SESSION) =========
session_start();
session_destroy();
session_unset();
header("Location:../index.php");

?>


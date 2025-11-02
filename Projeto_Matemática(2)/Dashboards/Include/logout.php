<?php
session_start();
session_unset();
session_destroy();
header("Location: ../../User_Registration/login.php");
exit();
?>
<?php
session_start();
session_unset();
session_destroy();
header("Location: ../../USUÁRIO/LOGIN/login.php");
exit();
?>
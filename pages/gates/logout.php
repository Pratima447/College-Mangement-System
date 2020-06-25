<?php
session_start();
unset($_SESSION['login']);
session_destroy();
setcookie('user', '', 0, "/");

header('location:/pages/gates/login.php');
?>

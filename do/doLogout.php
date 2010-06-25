<?php
require_once('classloader.php');
setcookie("id", '', time()-1209600);
setcookie("username", '', time()-1209600);
setcookie("token", '', time()-1209600);
unset($_SESSION['login']);
unset($_SESSION['ip']);
?>

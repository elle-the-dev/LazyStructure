<?php
require_once('../classloader.php');

setcookie("id", '', time()-1209600);
setcookie("username", '', time()-1209600);
setcookie("loginToken", '', time()-1209600);
unset($_SESSION['user']);
unset($_SESSION['ip']);

Reporting::endDo();
?>

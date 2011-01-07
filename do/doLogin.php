<?php
require_once('../global.php');

$user = new User();
$user->login($_POST['username'], $_POST['password'], $_POST['remember']);

Reporting::endDo();
?>

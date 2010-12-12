<?php
require_once('../global.php');
$username = $_POST['username'];
$password = $db->getHash($_POST['password']);
$remember = $_POST['remember'];

$user = new User();
$user->login($username, $password, $remember);

Reporting::endDo();
?>

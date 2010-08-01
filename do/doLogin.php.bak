<?php
require_once('classloader.php');
$username = $_POST['username'];
$password = $db->getHash($_POST['password']);
$remember = $_POST['remember'];
$row = $db->query("SELECT * FROM users WHERE username = ? AND password = ?", $username, $password);
if(is_array($row))
{
    if($remember == "true")
    {
        setcookie("id", $row[0]['id'], time()+1209600);
        setcookie("username", $row[0]['username'], time()+1209600);
        setcookie("token", $row[0]['token'], time()+1209600);
        setcookie("ip", $_SERVER['REMOTE_ADDR'], time()+1209600);
    }
    $_SESSION['login'] = $row[0];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
}
?>

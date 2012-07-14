<?php
require_once('global.php');

$out = new PageTemplate("resetComplete");
$username = $_GET['user'];
$token = $_GET['token'];
$db = new Model("resetComplete");
$rows = $db->query("select.sql", $username, $token);
if(is_array($rows) && strlen($token) > 5)
{
    $newpassword = $db->getRandomToken();
    $newpassword = substr($newpassword, 0, 8); 
    $hashed = $db->getPassword($newpassword, $db->getSalt());
    $db->query("update.sql", $hashed, $username);
    Mailer::sendNewPassword($rows[0]['id'], $newpassword);
    $out->body->content->addTemplate("success.tpl");
}
else
{
    $out->body->content->addTemplate("failure.tpl");
}
$out->render();
?>

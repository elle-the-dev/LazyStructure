<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "changePassword");
$out->title = "Change Password";

$out->body->content->addTemplate("content.tpl");

$out->render();
?>

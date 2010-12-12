<?php
require_once('global.php');

$out = new PageTemplate("login");
$out->title = "Login";

$out->body->content->addTemplate("content.tpl");

$out->render();
?>

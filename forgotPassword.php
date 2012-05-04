<?php
require_once('classloader.php');

$out = new PageTemplate("forgotPassword");
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

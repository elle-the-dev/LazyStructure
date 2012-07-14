<?php
require_once('global.php');

$out = new PageTemplate("forgotPassword");
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

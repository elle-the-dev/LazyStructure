<?php
require_once('../global.php');

$out = new PageTemplate("errors");
$out->title = "403 Forbidden";

$out->body->content->addTemplate("403.tpl");

$out->render();
?>

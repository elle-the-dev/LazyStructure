<?php
require_once('../global.php');

$out = new PageTemplate("errors");
$out->title = "Page cannot be found";

$out->body->content->addTemplate("404.tpl");

$out->render();
?>

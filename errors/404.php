<?php
require_once('../global.php');

$out = new PageTemplate("errors", false, "../templates/");
$out->title = "Page cannot be found";

$out->body->content->addTemplate("404.tpl");

$out->render();
?>

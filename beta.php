<?php
require_once('global.php');

$out = new PageTemplate("beta");
$out->title = "Beta";

$out->body->content->addTemplate("content.tpl");

$out->render();
?>

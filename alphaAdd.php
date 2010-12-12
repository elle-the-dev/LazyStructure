<?php
require_once('global.php');

$out = new PageTemplate("alphaAdd");
$out->title = "Add an Alpha";

$out->body->content->addTemplate("content.tpl");

$out->render();
?>

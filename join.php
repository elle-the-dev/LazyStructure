<?php
require_once('global.php');

$out = new PageTemplate("join");
$out->title = "Join";
$out->addStyle("css/join.css");

$out->body->content->fieldErrors = Reporting::getFieldErrors();
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

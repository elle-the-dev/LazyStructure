<?php
require_once('global.php');

$out = new PageTemplate("beta");
$out->addStyle('css/beta1.css');
$out->addStyle('css/beta2.css');
$out->title = "Beta";

$out->body->content->addTemplate("content.tpl");

$out->render();
?>

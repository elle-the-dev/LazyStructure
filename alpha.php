<?php
require_once('global.php');

$out = new PageTemplate("alpha");

$out->title = "Alpha";
$out->tab = "alpha";
$out->addSidebarItem("Add New", "alphaAdd.php");
$out->addStyle("css/alpha.css");

$db->init("alpha");
//print_r($db->queryRow("alpha"));
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

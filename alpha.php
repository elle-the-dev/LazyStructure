<?php
require_once('global.php');

$out = new PageTemplate("alpha");

$out->title = "Alpha";
$out->tab = "alpha";
$out->addSidebarItem("Add New", "alphaAdd.php");
$out->addSidebarItem("Google", "http://google.com");
$out->addStyle("css/alpha.css");

$db = new Model("alpha");
$out->test = "TESTING";
echo "*** ".$out->test." ***";
$out->addTemplate("content.tpl");

$out->render();
?>

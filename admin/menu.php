<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "pages");
$out->title = "Menu";
$out->addStyle("css/tablesorter.css");

$db = new Model("admin/menu");
$rows = $db->query("select.sql");

$tableSettings = array(
    'id' => 'pages',
    'class' => 'tablesorter',
    'editable' => true,
    'editAction' => PATH.'admin/updatePage.php',
    'editMethod' => 'get',
    'deletable' => true,
    'deleteAction' => PATH.'admin/confirmDeletePages.php',
    'deleteMethod' => 'post'
);

$columnSettings = array(
    'id' => array('visible' => false)
);

$out->body->content->table = new LazyTable($rows, $tableSettings, $columnSettings);
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "actions");
$out->title = "Actions";
$out->addStyle("css/tablesorter.css");

$db = new Model("admin/actions");
$rows = $db->query("select.sql");

$tableSettings = array(
    'id' => 'actions',
    'class' => 'tablesorter',
    'editable' => true,
    'editAction' => PATH.'admin/updateAction.php',
    'editMethod' => 'get',
    'deletable' => true,
    'deleteAction' => PATH.'admin/confirmDeleteAction.php',
    'deleteMethod' => 'post'
);

$columnSettings = array(
    'id' => array('visible' => false)
);

$out->body->content->table = new LazyTable($rows, $tableSettings, $columnSettings);
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

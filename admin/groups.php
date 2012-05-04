<?php
require_once('../global.php');

$out = new AdminTemplate(GROUPS, "groups");
$out->title = "Groups";
$out->addStyle("css/tablesorter.css");
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$db = new Model("admin/groups");

$pagination = new Pagination($db->queryColumn("total.sql"), $page, ROWS_PER_PAGE, BREAK_PAGES, "admin/");
$pagination->generate();
$out->body->content->pagination = $pagination;

$db->limit = $pagination->limit;
$rows = $db->query("select.sql");

$tableSettings = array(
    'id' => 'groups',
    'class' => 'tablesorter',
    'editable' => true,
    'editAction' => PATH.'admin/updateGroup.php',
    'editMethod' => 'get',
    'deletable' => true,
    'deleteAction' => PATH.'admin/confirmDeleteGroups.php',
    'deleteMethod' => 'post'
);

$columnSettings = array(
    'id' => array('visible' => false)
);

$out->body->content->table = new LazyTable($rows, $tableSettings, $columnSettings);
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

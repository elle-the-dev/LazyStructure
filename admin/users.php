<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "users");
$out->title = "Users";
$out->addStyle("css/tablesorter.css");
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$db = new Model("admin/users");

$pagination = new Pagination($db->queryColumn("total.sql"), $page, ROWS_PER_PAGE, BREAK_PAGES, "admin/");
$pagination->generate();
$out->body->content->pagination = $pagination;
$db->limit = $pagination->limit;
$rows = $db->query("select.sql");

$tableSettings = array(
    'id' => 'users',
    'class' => 'tablesorter',
    'editable' => true,
    'editAction' => PATH.'admin/updateUser.php',
    'editMethod' => 'get',
    'deletable' => true,
    'deleteAction' => PATH.'admin/confirmDeleteUsers.php',
    'deleteMethod' => 'post'
);

$columnSettings = array(
    'id' => array('visible' => false)
);

$out->body->content->table = new LazyTable($rows, $tableSettings, $columnSettings);
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

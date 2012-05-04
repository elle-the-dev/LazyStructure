<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "pages");
$out->title = "Pages";
$out->addStyle("css/tablesorter.css");
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

$db = new Model("admin/pages");

$pagination = new Pagination($db->queryColumn("total.sql"), $page, ROWS_PER_PAGE, BREAK_PAGES, 'admin/');
$pagination->generate();
$out->body->content->pagination = $pagination;

$db->limit = $pagination->limit;
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
    'id' => array('visible' => false),
    'title' => array('link' => PATH.'__id__/__title__')
);


$out->body->content->table = new LazyTable($rows, $tableSettings, $columnSettings);
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

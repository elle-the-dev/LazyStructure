<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "updatePage");
$out->title = "Page";
$out->addStyle("css/permissions.css");
$db = new Model("admin/updatePage");

if($out->body->content->id = isset($_GET['id']) ? (int) $_GET['id'] : false) // editing
{
    $out->body->content->fields = $db->queryRow("select.sql", $out->body->content->id);
    $out->body->content->editable = $out->body->content->fields['editable'] ? ' checked="checked"' : "";
}
else // blank form for new record
{
    $out->body->content->fields = array();
    $out->body->content->disabled = '';
}

$out->body->content->fieldErrors = Reporting::getFieldErrors();

if(!$out->body->content->fieldErrors)
    $out->body->content->fieldErrors = array('name'=>'','key'=>'','description'=>'');
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

<?php
require_once('../global.php');

$out = new AdminTemplate(GROUPS, "updateGroup");
$out->title = "User";
$out->addStyle("css/permissions.css");
$db = new Model("admin/updateGroup");

if($out->body->content->id = isset($_GET['id']) ? (int) $_GET['id'] : false) // editing
{
    $out->body->content->fields = $db->queryRow("select.sql", $out->body->content->id);
}
else // blank form for new record
{
    $out->body->content->fields = array('name' => '', 'description' => '');
    $out->body->content->disabled = '';
}

$pages = $db->query($out->body->content->id === GROUP_GUEST ? "selectGuestPages.sql" : "selectPages.sql", $out->body->content->id);
$allowedPages = array();
$disallowedPages = array();
if(!empty($pages))
    foreach($pages as $page)
        $page['group_id'] ? $allowedPages[] = $page : $disallowedPages[] = $page;

$actions = $db->query("selectActions.sql", $out->body->content->id);
$allowedActions = array();
$disallowedActions = array();
if(!empty($actions))
    foreach($actions as $action)
        $action['group_id'] ? $allowedActions[] = $action : $disallowedActions[] = $action;

$out->body->content->allowedPages = new HtmlSelect($allowedPages, array(
    'selected' => null,
    'id' => "allowedPages",
    'name' => "allowedPages",
    'class' => null,
    'value' => "id", 
    'label' => "title", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->disallowedPages = new HtmlSelect($disallowedPages, array(
    'selected' => null,
    'id' => "disallowedPages",
    'name' => "disallowedPages",
    'class' => null,
    'value' => "id", 
    'label' => "title", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->allowedActions = new HtmlSelect($allowedActions, array(
    'selected' => null,
    'id' => "allowedActions",
    'name' => "allowedActions",
    'class' => null,
    'value' => "id", 
    'label' => "name", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->disallowedActions = new HtmlSelect($disallowedActions, array(
    'selected' => null,
    'id' => "disallowedActions",
    'name' => "disallowedActions",
    'class' => null,
    'value' => "id", 
    'label' => "name", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->allowedPages->generate();
$out->body->content->disallowedPages->generate();

$out->body->content->allowedActions->generate();
$out->body->content->disallowedActions->generate();

$out->body->content->fieldErrors = Reporting::getFieldErrors();

if(!$out->body->content->fieldErrors)
    $out->body->content->fieldErrors = array('name' => '', 'description' => '');
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

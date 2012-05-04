<?php
require_once('../global.php');

$out = new AdminTemplate(USERS, "updateUser");
$out->title = "User";
$out->addStyle("css/permissions.css");
$db = new Model("admin/updateUser");

$out->body->content->changePassword = new View("admin/updateUser/changePassword");
if($out->body->content->id = isset($_GET['id']) ? (int) $_GET['id'] : false) // editing
{
    $out->body->content->fields = $db->queryRow("select.sql", $out->body->content->id);
    $out->body->content->disabled = ' disabled="disabled"';
    $out->body->content->changePassword->addTemplate("content.tpl");
}
else // blank form for new record
{
    $out->body->content->fields = array();
    $out->body->content->disabled = '';
}

$groups = $db->query("selectGroups.sql", $out->body->content->id);
$allowedGroups = array();
$disallowedGroups = array();
foreach($groups as $group)
    $group['user_id'] ? $allowedGroups[] = $group : $disallowedGroups[] = $group;

$out->body->content->allowedGroups = new HtmlSelect($allowedGroups, array(
    'selected' => null,
    'id' => "allowedGroups",
    'name' => "allowedGroups",
    'class' => null,
    'value' => "id", 
    'label' => "name", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->disallowedGroups = new HtmlSelect($disallowedGroups, array(
    'selected' => null,
    'id' => "disallowedGroups",
    'name' => "disallowedGroups",
    'class' => null,
    'value' => "id", 
    'label' => "name", 
    'size' => PERMISSIONS_SELECT_SIZE,
    'multiple' => true)
);

$out->body->content->allowedGroups->generate();
$out->body->content->disallowedGroups->generate();


$out->body->content->fieldErrors = Reporting::getFieldErrors();


if(!$out->body->content->fieldErrors)
    $out->body->content->fieldErrors = array('username'=>'','password'=>'','passwordConfirm'=>'','email'=>'','name'=>'','surname'=>'','phone'=>'','address1'=>'','address2'=>'','city'=>'');
$out->body->content->addTemplate("content.tpl");

$out->render();
?>

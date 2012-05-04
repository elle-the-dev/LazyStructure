<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(USERS);

$db = new Model("do/admin/doDeleteUsers");

if(isset($_POST['cancel']))
{
    Reporting::setRedirect(PATH."admin/users.php");
    Reporting::endDo();
    die;
}

$ids = json_decode($_POST['ids']);
$db->placeholders = $db->getPlaceholders($ids);
$db->query("delete.sql", $ids);
$db->query("deleteGroupsToUsers.sql", $ids);
Reporting::setSuccess("Users deleted successfully.");
Reporting::setRedirect(PATH."admin/users.php");

Reporting::endDo();
?>

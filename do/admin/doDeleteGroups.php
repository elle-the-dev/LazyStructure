<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(GROUPS);

$db = new Model("do/admin/doDeleteGroups");

if(isset($_POST['cancel']))
{
    Reporting::setRedirect(PATH."admin/groups.php");
    Reporting::endDo();
    die;
}

$ids = json_decode($_POST['ids']);
$db->placeholders = $db->getPlaceholders($ids);
$db->query("delete.sql", $ids);
$db->query("deleteActionsToGroups.sql", $ids);
$db->query("deleteGroupsToUsers.sql", $ids);
Reporting::setSuccess("Groups deleted successfully.");
Reporting::setRedirect(PATH."admin/groups.php");

Reporting::endDo();
?>

<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(ACTIONS);

$db = new Model("do/admin/doDeleteActions");

if(isset($_POST['cancel']))
{
    Reporting::setRedirect(PATH."admin/actions.php");
    Reporting::endDo();
    die;
}

$ids = json_decode($_POST['ids']);
$db->placeholders = $db->getPlaceholders($ids);
$db->query("deleteActionsToGroups.sql", $ids);
$db->query("delete.sql", $ids);
Reporting::setSuccess("Actions deleted successfully.");
Reporting::setRedirect(PATH."admin/actions.php");

Reporting::endDo();
?>

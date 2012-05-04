<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(PAGES);

$db = new Model("do/admin/doDeletePages");

if(isset($_POST['cancel']))
{
    Reporting::setRedirect(PATH."admin/pages.php");
    Reporting::endDo();
    die;
}

$ids = json_decode($_POST['ids']);
$db->placeholders = $db->getPlaceholders($ids);
$db->query("delete.sql", $ids);
Reporting::setSuccess("Pages deleted successfully.");
Reporting::setRedirect(PATH."admin/pages.php");

Reporting::endDo();
?>

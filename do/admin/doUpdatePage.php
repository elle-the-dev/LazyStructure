<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticatePage(USERS);

$id = (int) $_POST['id'];

$title      = Filter::filterStrong($_POST['title']);
$editable   = isset($_POST['editable']) ? 1 : 0;

$db = new Model("do/admin/doUpdatePage");

if(empty($title))
    Reporting::setFieldError("title", "Required");

if(!Reporting::hasAnyErrors())
{
    if($id)
    {
        if($db->query("update.sql", $title, $editable, $id))
            Reporting::setSuccess("Update completed successfully.");
        else
            Reporting::setError("Something went wrong!  Please try again.");
    }
    else
    {
        if($db->query("insert.sql", $title, $editable))
            Reporting::setSuccess("Page created successfully.");
        else
            Reporting::setError("Something went wrong!  Please try again.");
    }
}

Reporting::endDo();
?>

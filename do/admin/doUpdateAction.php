<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(USERS);

$id = (int) $_POST['id'];

$key      = Filter::filterStrong($_POST['key']);
$name     = Filter::filterStrong($_POST['name']);
$description     = Filter::filterStrong($_POST['description']);

$db = new Model("do/admin/doUpdateAction");

if(!preg_match('/[A-Za-z_]/', $key))
    Reporting::setFieldError("key", "Invalid key");
if(empty($name))
    Reporting::setFieldError("name", "Required");

if(!Reporting::hasAnyErrors())
{
    if($id)
    {
        if($db->query("update.sql", $key, $name, $description, $id))
            Reporting::setSuccess("Update completed successfully.");
        else
            Reporting::setError("Something went wrong!  Please try again.");
    }
    else
    {
        if($db->query("insert.sql", $key, $name, $description))
            Reporting::setSuccess("Action created successfully.");
        else
            Reporting::setError("Something went wrong!  Please try again.");
    }
}

Reporting::endDo();
?>

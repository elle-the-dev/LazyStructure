<?php
require_once('../../global.php');
require_once('../authenticate.php');
$permissions->authenticateAction(GROUPS);

$id = (int) $_POST['id'];

$name        = Filter::filterStrong($_POST['name']);
$description = Filter::filterStrong($_POST['description']);
$allowedPages = isset($_POST['allowedPages']) ? $_POST['allowedPages'] : array();
$allowedActions = isset($_POST['allowedActions']) ? $_POST['allowedActions'] : array();

$db = new Model("do/admin/doUpdateGroup");
if(empty($name))
    Reporting::setFieldError("name", "Required");

if(!Reporting::hasAnyErrors())
{
    if($id)
    {
        $db->query("deleteGroupToPages.sql", $id);
        foreach($allowedPages as $allowedPage)
            $db->query("insertGroupToPages.sql", $id, $allowedPage);

        $db->query("deleteActionsToGroup.sql", $id);
        foreach($allowedActions as $allowedAction)
            $db->query("insertActionsToGroup.sql", $allowedAction, $id);

        $db->query("update.sql", $name, $description, $id);
        Reporting::setSuccess("Group updated successfully");
        Reporting::setRedirect(PATH."admin/groups.php");
    }
    else
    {
        if($id = $db->query("insert.sql", $name, $description))
        {
            foreach($allowedPages as $allowedPage)
                $db->query("insertGroupToPages.sql", $id, $allowedPage);
            foreach($allowedActions as $allowedAction)
                $db->query("insertActionsToGroup.sql", $allowedAction, $id);
            Reporting::setSuccess("Group created successfully.");
            Reporting::setRedirect(PATH."admin/groups.php");
        }
        else
            Reporting::setError("Something went wrong!  The data is valid, but inserting into the database failed.  Please try again.");
    }
}

Reporting::endDo();
?>

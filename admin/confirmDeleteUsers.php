<?php
require_once('../global.php');

$out = new ConfirmDeleteTemplate(GROUPS, "username", "users");
$out->title = "Delete Users";

if(!isset($_POST['id']))
{
    Reporting::setError("You didn't select any users");
    Reporting::setRedirect(PATH."admin/users.php");
    Reporting::endDo();
}
else if(in_array($user->id, $_POST['id']))
{
    Reporting::setError("Cannot delete yourself");
    Reporting::setRedirect(PATH."admin/users.php");
    Reporting::endDo();
    die;
}

$out->render();
?>

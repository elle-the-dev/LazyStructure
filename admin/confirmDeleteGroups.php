<?php
require_once('../global.php');

$out = new ConfirmDeleteTemplate(GROUPS, "name", "groups");
$out->title = "Delete Groups";

if(!isset($_POST['id']))
{
    Reporting::setError("You didn't select any groups");
    Reporting::setRedirect(PATH."admin/groups.php");
    Reporting::endDo();
}
else if(in_array(GROUP_GUEST, $_POST['id']))
{
    Reporting::setError("Cannot delete guest group");
    Reporting::setRedirect(PATH."admin/groups.php");
    Reporting::endDo();
}
else if(in_array(GROUP_ADMIN, $_POST['id']))
{
    Reporting::setError("Cannot delete admin group");
    Reporting::setRedirect(PATH."admin/groups.php");
    Reporting::endDo();
}

$out->render();
?>

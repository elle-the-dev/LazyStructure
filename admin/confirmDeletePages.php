<?php
require_once('../global.php');

$out = new ConfirmDeleteTemplate(PAGES, "title", "pages");
$out->title = "Delete Pages";

if(!isset($_POST['id']))
{
    Reporting::setError("You didn't select any pages");
    Reporting::setRedirect(PATH."admin/pages.php");
    Reporting::endDo();
}
else if(in_array(1, $_POST['id']))
{
    Reporting::setError("Cannot delete index page");
    Reporting::setRedirect(PATH."admin/pages.php");
    Reporting::endDo();
    die;
}

$out->render();
?>

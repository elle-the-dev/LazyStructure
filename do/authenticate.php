<?php
if(!$db->authenticate($_POST['xsrfToken']))
{
    Reporting::setError("Security token mismatch. Refresh and try again, and if it still fails, log out then back in.");
    Reporting::endDo();
    die;
}

if(isset($_POST['cancel']))
{
    Reporting::setRedirect($_SESSION['lastLastPage']);
    Reporting::endDo();
    die;
}
?>

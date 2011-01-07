<?php
require_once('../global.php');
$db->init("do/doUpdatePage");
$pageId = (int) $_POST['pageId'];
$pageHeading = strip_tags($_POST['pageHeading']);
$content = $_POST['content'];

if($db->authenticate($_POST['xsrfToken']))
{
    $db->query("update.sql", $pageHeading, $content, $pageId);
    Reporting::setSuccess("Page saved.");
}
else
    Reporting::setError("You are not authorized to perform this action.");

Reporting::endDo();
?>

<?php
require_once('../classloader.php');
$pageId = (int) $_POST['pageId'];
$pageHeading = strip_tags($_POST['pageHeading']);
$content = $_POST['content'];

if($db->authenticate($_POST['xsrfToken']))
{
    $db->query("UPDATE pages SET heading = ?, content = ? WHERE id = ?", $pageHeading, $content, $pageId);
    Reporting::setSuccess("Page saved.");
}
else
    Reporting::setError("You are not authorized to perform this action.");

Reporting::endDo();
?>

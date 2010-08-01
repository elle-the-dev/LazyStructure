<?php
require_once('../classloader.php');
$pageId = (int) $_POST['pageId'];
$content = $_POST['content'];

if($db->authenticate($_POST['xsrfToken']))
{
    $db->query("UPDATE pages SET content = ? WHERE id = ?", $content, $pageId);
    Reporting::setSuccess("Page saved.");
}
else
    Reporting::setError("You are not authorized to perform this action.");

Reporting::endDo();
?>


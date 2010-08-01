<?php
require_once('classloader.php');

isset($_GET['pageId']) ? $pageId = (int) $_GET['pageId'] : $pageId = 1;
$page = $db->queryRow("SELECT title, heading, content, editable FROM pages WHERE id = ?", $pageId);

$out = new PageTemplate();
$out->title = $page['title'];
$out->heading = $page['heading'];

$user ? $xsrfToken = $user->xsrfToken : $xsrfToken = "";
if($db->authenticate($xsrfToken))
    $page['editable'] ? $divId = "userContent" : $divId = "staticContent";
else
    $divId = "staticContent";

$out->body .= <<<OUT
<script type="text/javascript" src="{$path}nicedit/nicEdit.php"></script>
<div id="adminPanel">
    <div id="userContentPanel"></div>
    <div id="adminErrors" class="errors"></div>
    <div id="adminSuccesses" class="successes"></div>
</div>
<div id="{$divId}">
    {$page['content']}
</div>
<input type="hidden" id="pageId" value="{$pageId}" />
<input type="hidden" id="xsrfToken" value="{$xsrfToken}" />
<input type="hidden" id="path" value="{$path}" />
OUT;
$out->render();
?>

<?php
require_once('global.php');

$out = new PageTemplate("index");
$db->init("index");

$out->body->content->pageId = isset($_GET['pageId']) ? (int) $_GET['pageId'] : 1;
$page = $db->queryRow("pages.sql", $out->body->content->pageId);

$out->title = $page['title'];
$out->body->heading = Filter::toXhtml($page['heading']);
$out->body->content->pageContent = Filter::toXhtml($page['content']);
$out->body->content->xsrfToken = $user ? $user->xsrfToken : "";

// top menu bar
$out->body->content->adminPanel = new View("index/adminPanel");

if($db->authenticate($out->body->content->xsrfToken))
{
    // userContent will start nicEditor
    // staticContent will appear as a normal web page
    $out->body->content->divId = $page['editable'] ? "userContent" : "staticContent";
    if($page['editable'])
    {
        $out->addStyle(PATH."css/admin.css");
        $out->body->content->adminPanel->addTemplate("content.tpl");
    }
}
else
    $out->body->content->divId = "staticContent";

$out->body->content->addTemplate("content.tpl");
$out->render();
?>

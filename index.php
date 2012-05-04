<?php
require_once('global.php');

$out = new PageTemplate("index");
$db = new Model("index");

$out->body->content->pageId = isset($_GET['pageId']) ? (int) $_GET['pageId'] : 1;
$permissions->authenticatePage($out->body->content->pageId);

$page = $db->queryRow("pages.sql", $out->body->content->pageId);

$out->title = $page['title'];
$out->body->heading = Filter::toXhtml($page['heading']);
$out->body->content->pageContent = Filter::toXhtml($page['content']);
$out->body->content->xsrfToken = $user ? $user->xsrfToken : "";

// top menu bar
$out->body->content->adminPanel = new View("index/adminPanel");
$pageDb = new Model("classes/PageTemplate");
$sidebarItems = $pageDb->query("sidebar.sql", $out->body->content->pageId);
if(!empty($sidebarItems))
{
    foreach($sidebarItems as $item)
    {
        $out->addSidebarItem($item['title'], $item['link']);
    }
}

if($db->authenticate($out->body->content->xsrfToken))
{
    // userContent will start nicEditor
    // staticContent will appear as a normal web page
    $out->body->content->divId = $page['editable'] ? "userContent" : "staticContent";
    $out->addSidebarItem("+", "#", "addPageMenuItem ignore");

    if($page['editable'] && $permissions->isAuthorizedAction(CONTENT_EDIT))
    {
        $out->addStyle("css/admin.css");
        $out->body->content->adminPanel->addTemplate("content.tpl");
    }
}
else
    $out->body->content->divId = "staticContent";

$out->body->content->addTemplate("content.tpl");
$out->render();
?>

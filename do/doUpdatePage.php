<?php
require_once('../global.php');
require_once('authenticate.php');
$db = new Model("do/doUpdatePage");
$pageId = (int) $_POST['pageId'];
$pageHeading = strip_tags($_POST['pageHeading']);
$content = $_POST['content'];

if($permissions->canEditPage($pageId))
{
    $db->query("update.sql", $pageHeading, $content, $pageId);
    $db->query("deleteMainMenu.sql", $user->id);
    updateMenu("main_menu", $_POST['tabsMenu']);
    if(isset($_POST['sideMenu']))
    {
        $db->query("deletePageMenu.sql", $user->id);
        updateMenu("page_menu", $_POST['sideMenu'], null, null, $pageId);
    }
    Reporting::setSuccess("Page saved.");
}
else
    Reporting::setError("You are not authorized to perform this action.");

Reporting::endDo();


function updateMenu($table, $ul, $updateParent=true, $parentId=null, $pageId=null)
{
    $db = new Model("do/doUpdatePage");
    $db->table = $table;
    $count = 1;
    global $user;
    if(is_array($ul))
    {
        foreach($ul as $li)
        {
            /*
            if(strtolower(substr($li['link'],0,7)) != "http://")
            {
                $link = substr($li['rel'], 8);
                $isAjax = 1;
            }
            else
            {
                $link = $li['link'];
                $isAjax = 0;
            }
            */
            $link = $li['link'];
            $isAjax = 0;

            if($updateParent)
            {
                if($pageId)
                    $id = $db->queryColumn("insertPageMenuParent.sql", $li['title'], $link, $parentId, $count, $isAjax, $pageId);
                else
                    $id = $db->queryColumn("insertMainMenuParent.sql", $li['title'], $link, $parentId, $count, $isAjax);
            }
            else
            {
                if($pageId)
                    $id = $db->queryColumn("insertPageMenu.sql", $li['title'], $link, $count, $isAjax, $pageId);
                else
                    $id = $db->queryColumn("insertMainMenu.sql", $li['title'], $link, $count, $isAjax);
            }
            $count++;
            if($updateParent && isset($li['children']))
                updateMenu($table, $li['children'], true, $id, $pageId);
        }
    }
}
?>

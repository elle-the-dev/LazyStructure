$(document).ready(function()
{
    $('#addPermissionPage').bind('click', function()
    {
        moveRelation("allowedPages", "disallowedPages");
    });

    $('#removePermissionPage').bind('click', function()
    {
        moveRelation("disallowedPages", "allowedPages");
    });

    $('#addPermissionAction').bind('click', function()
    {
        moveRelation("allowedActions", "disallowedActions");
    });

    $('#removePermissionAction').bind('click', function()
    {
        moveRelation("disallowedActions", "allowedActions");
    });
});



$(document).ready(function()
{
    $('#addPermission').bind('click', function()
    {
        moveRelation("allowedGroups", "disallowedGroups");
    });

    $('#removePermission').bind('click', function()
    {
        moveRelation("disallowedGroups", "allowedGroups");
    });
});



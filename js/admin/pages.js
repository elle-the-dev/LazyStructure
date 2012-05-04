$(document).ready(function()
{
    $('#pages .editForm').bind('submit', function()
    {
        var queryString = "";
        $(this).find('input[type=hidden]').each(function()
        {
            queryString += this.name + "=" + this.value;
        });
        window.location = (this.action+'?'+queryString);
        //loadPage(this.action+'?'+queryString, true);
        return false;
    });
});

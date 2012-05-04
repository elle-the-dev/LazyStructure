$(document).ready(function()
{
    $('.passwordRow').css('display', 'none');
    $('#changePassword').bind('change', function()
    {
        $('.passwordRow').css('display', this.checked ? 'table-row' : 'none'); 
        //$('.passwordRow').effect('highlight', {}, 3000);
    });
});

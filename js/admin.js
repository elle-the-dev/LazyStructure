$(document).ready(function()
{
    $('#tabs > ul').append('<li class="addTab ignore"><a href="javascript:;" onclick="addTab(this);">+</a></li>');
    $('#newTabPage').bind('change', function()
    {
        var pageId = $('#newTabPage').val();
        var pageLabel = $('#newTabPage option:selected').text();
        $('#newTabUrl').val(PATH + pageId + '/' + pageLabel);
    });
    $('.addPageMenuItem a').bind('click', function()
    {
        addTab(this);
    });
    $('#newTab').bind('dialogclose', function()
    {
        $('#mostRecentTabUsed').val('0');
    });
    bindTabs();
});

var fadeOut = false;
function bindTabs()
{
    $('#tabs ul > li').unbind('mouseover').bind('mouseover', function()
    {
        showTooltip(this, 'tabsTooltip');
        return false;
    });
    $('#sidebar ul > li').unbind('mouseover').bind('mouseover', function()
    {
        showTooltip(this, 'sidebarTooltip');
    });

    $('#tabs ul > li.ignore, #sidebar ul > li.ignore').unbind('mouseover');
    $('#tabTooltip').bind('mouseover', function()
    {
        fadeOut = false;
        showMenus();
    });
    $('#tabTooltip').bind('mouseout', function()
    {
        hideMenus();
    });

    $('#tabs ul > li, #sidebar ul > li, #tabTooltip').bind('mouseout', function()
    {
        fadeOut = true;
        setTimeout(function()
        {
            if(fadeOut)
                $('#tabTooltip').fadeOut();
        }, 1000);
    });

    $('#tabs ul ul').sortable(
    {   
        start: tabStart,
        stop: tabStop,
        tolerance: 'pointer',
        revert: true,
        items: 'li:not(".ignore")',
        helper: 'clone',
        connectWith: '#tabs ul',
        placeholder: 'placeholder',
        opacity: '0.6',
        forcePlaceholderSize: true
    }); 
    $('#tabs ul ul').disableSelection();

    $('#tabs > ul').sortable(
    {   
        start: tabStart,
        stop: tabStop,
        tolerance: 'pointer',
        revert: true,
        items: 'li:not(".ignore")',
        helper: 'clone',
        connectWith: '#tabs ul ul',
        placeholder: 'placeholder',
        opacity: '0.6',
        forcePlaceholderSize: true
    }); 
    $('#tabs ul').disableSelection();

    /*
    $('#footer ul').sortable(
    {   
        tolerance: 'pointer',
        revert: true,
        items: 'li:not(".ignore")',
        helper: 'clone',
        placeholder: 'placeholder',
        opacity: '0.6',
        forcePlaceholderSize: true
    }); 
    $('ul, #footer ul').disableSelection();
    */

    $('#sidebar ul').sortable(
    {
        tolerance: 'pointer',
        revert: true,
        items: 'li:not(".ignore")',
        helper: 'clone',
        placeholder: 'placeholder',
        opacity: '0.6',
        forcePlaceholderSize: true
    });
}

var tabSorting = false;
function tabStart(event, ui)
{
    showMenus();
    tabSorting=true;
    placeholderLoop();
}

function tabStop(event, ui)
{
    hideMenus();
    placeholderLoop();
    tabSorting=false;
}

function showTooltip(obj, className)
{
        fadeOut = false;
        $('#tabTooltip #editTabName').val($(obj).find('span').html());
        $('#tabTooltip #editTabUrl').val($(obj).find('a').attr('href'));
        $('#tabTooltip').css({
            display: 'block',
            position: 'absolute',
            top: $(obj).offset().top,
            left: $(obj).offset().left,
        });
        $('#tabTooltip').attr('class', className);
        if($('#mostRecentTabUsed').val() !== '1')
        {
            $('#mostRecentTabUsed').remove();
            $(obj).append('<input type="hidden" id="mostRecentTabUsed" value="0" />');
        }
}

function addTab(obj)
{
    $('#newTab input[type=submit]').unbind('click').bind('click', function()
    {
        var name = $('#newTabName').val();
        var li = '<li>'
                + '<a href="' + $('#newTabUrl').val() + '"><span>' + name + '</span></a>'
                + '<ul class="ui-sortable"><li class="empty"></li></ul>'
                + '</li>';

        if($('#mostRecentTabUsed').val() == '1')
            $(obj).closest('li').replaceWith(li);
        else
            $(obj).closest('li').parent().find('li.ignore:first').before(li);
        $('#newTab').dialog('close');
        bindTabs();
    });

    $('#newTabName').val("");
    $('#newTabUrl').val("");
    $('#newTab').dialog( { width: 400 } );
    //$(obj).closest('li').before('<li><a>test</a></li>');
}

function editTab()
{
    addTab($('#mostRecentTabUsed'));
    $('#newTabName').val($('#editTabName').val());
    $('#newTabUrl').val($('#editTabUrl').val());
    $('#mostRecentTabUsed').val('1');
    $('#tabTooltip').hide();
}

function deleteTab()
{
    $('#mostRecentTabUsed').closest('li').remove();
    $('#tabTooltip').hide();
}

function getMenuJson(ul)
{
    var obj = {};
    var count = 0;
    ul.children('li').each(function()
    {
        if(!$(this).hasClass('empty') && !$(this).hasClass('ignore'))
        {
            obj[count] = {};
            obj[count]['id'] = $(this).children('input.menuItemId').val();
            obj[count]['title'] = $(this).find('a span').html();
            obj[count]['link'] = $(this).children('a').attr('href');
            if($(this).children('a').attr('rel'))
                obj[count]['rel'] = $(this).children('a').attr('rel');
            obj[count]['children'] = getMenuJson($(this).children('ul'));
            count++;
        }
    });
    return obj;
}

function adminPanel()
{
    userContentEditor = new nicEditor(
    {
        buttonList: ['save','bold','italic','underline','strikethrough','left','center','right','justify','subscript','superscript','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','image','upload','fileupload','filemanager','link','unlink','forecolor','bgcolor','removeformat','xhtml','stopediting'],
        xhtml: true,
        onSave: function(content, id, instance)
        {
            nicEditSubmit(content, id);
        }
    });
    userContentEditor.setPanel('userContentPanel');
    userContentEditor.addInstance('userContent');
    userContentEditor.addInstance('pageHeading');

}

function showMenus(event, ui)
{
    $('#tabs li.empty').html('<a href="#">&nbsp;</a>');
    $('#tabs ul li').addClass('sorting');
}

function hideMenus()
{
    $('#tabs li.empty').html(' ');
    $('#tabs ul li').removeClass('sorting');
    $('#tabs ul').each(function ()
    {
        if($(this).html() == "")
        {
            $(this).html('<li style="" class="empty ignore"> </li>');
        }
    });
}

function nicEditSubmit(content, id)
{
    if(id == "userContent")
        var pageHeading = $('#pageHeading').html();
    else
    {
        var pageHeading = content;
        content = $('#userContent').html();
    }
    var pageId = $('#pageId').val();
    var xsrfToken = $('#xsrfToken').val();
    var url = PATH+'do/doUpdatePage.php';
    var tabsMenu = getMenuJson($('#tabs ul.mainMenu'));
    var sideMenu = getMenuJson($('#sidebar ul'));

    $.post(url, {pageId: pageId, pageHeading: pageHeading, content: content, tabsMenu: tabsMenu, sideMenu: sideMenu, xsrfToken: xsrfToken}, function(data)
    {
        var message = $.parseJSON(data);
        showAll(message, 'adminErrors', 'adminSuccesses');
    });
    return false;
}

function placeholderLoop()
{
    if(tabSorting)
    {
        $('.dropzone').removeClass('dropzone');
        $('.placeholder').closest('div > ul > li').addClass('dropzone');
        setTimeout('placeholderLoop()', 350);
    }
}

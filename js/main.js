var MESSAGE_SPEED = 500;
var messages = { errors: Array(), successes: Array() };
var userContentEditor;
var pageHeadingEditor;

function loadPage(obj, inline)
{
    
    /*
        The jQuery address plugin does not work if the link is
        in the AJAX content area (main). This fixes that.
    */
    if(!inline)
    {
        var url = (""+window.location).replace(/([^\#!])\/[0-9]+\/[a-zA-Z-_\.\|']+\/?/, "\$1");
        if(url != window.location)
            window.location = url+'#!/'+obj.rel.substring(8);
        else
            window.location='#!/'+obj.rel.substring(8);
    }
    else
    {
        var main = $('#main');
        main.addClass('loading');

        // Clears everything out so all the user sees is the loading animation
        $('#mainContent').css('opacity', '0.3');

        $.getJSON(obj, function(data)
        {
            $('#mainContent').css('opacity', '1');
            $('.pageStyle').remove();
            $('head').append(getStyles(data['styles']));
            main.removeClass('loading');
            main.html(data['markup'].toString());
            $(document).attr('title', data['title'].toString());
            bindClick();

            if(typeof $('#userContent').val() != "undefined")
            {
                userContentEditor = new nicEditor(
                {
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
        });
    }
    return false;
}

function formSubmit(obj, callback, postCallBack)
{
    var form = $(obj);
    var submit = form.find('input[type="submit"]');
    submit.attr('disabled', 'disabled');
    submit.after('<span class="waitingNotice">Please wait...</span>');
    $.post(obj.action, form.serialize(), function(data)
    {
        if(typeof callBack == "undefined" || callBack(data))
        {
            try
            {
                // Return data is JSON object string, so eval to get object
                var message = $.parseJSON(data);
                if(message != "undefined")
                    showAll(message);
            }
            catch(err)
            {
                setError(data);
                showErrors(messages['errors']);
            }
        }
        form.find('.waitingNotice').remove();
        submit.removeAttr('disabled');
        if(typeof postCallBack != "undefined")
            postCallBack(data);
    });
    return false;
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
    var url = $('#path').val()+'do/doUpdatePage.php';

    $.post(url, {pageId: pageId, pageHeading: pageHeading, content: content, xsrfToken: xsrfToken}, function(data)
    {
        // Return data is JSON object string, so eval to get object
        var message = $.parseJSON(data);
        showAll(message, 'adminErrors', 'adminSuccesses');
    });
    return false;
}

function setError(message)
{
    messages['errors'][messages['errors'].length] = message;
}

function setSuccess(message)
{
    messages['successes'][messages['successes'].length] = message;
}

function showAll(message, errorsId, successesId)
{
    if(typeof errorsId == "undefined")
        errorsId = "errors";
    if(typeof successesId == "undefined")
        successesId = "successes";

    showErrors(message['errors'], errorsId, successesId);
    showSuccesses(message['successes'], errorsId, successesId);
    showFieldErrors(message['fieldErrors']);
}

function showErrors(messages, errorsId, successesId)
{
    if(typeof messages != "undefined")
    {
        if(typeof errorsId == "undefined")
            errorsId = "errors";
        if(typeof successesId == "undefined")
            successesId = "successes";

        $('#'+successesId).css('display', 'none');
        var errors = $('#'+errorsId);
        errors.css('display', 'none');
        errors.html(getMessageList(messages));
        errors.fadeIn(MESSAGE_SPEED);
        errors.css('display', 'block');
    }
}

function showSuccesses(messages, errorsId, successesId)
{
    if(typeof messages != "undefined")
    {
        if(typeof errorsId == "undefined")
            errorsId = "errors";
        if(typeof successesId == "undefined")
            successesId = "successes";

        $('#'+errorsId).css('display', 'none');
        var successes = $('#'+successesId);
        successes.css('display', 'none');
        successes.html(getMessageList(messages));
        successes.fadeIn(MESSAGE_SPEED);
        successes.css('display', 'block');
        successes.delay(2000).fadeOut(MESSAGE_SPEED);
    }
}

function showFieldErrors(messages)
{
    $('.fieldError').remove();
    if(typeof messages != "undefined")
    {
        for(i in messages)
        {
            var error = $('#'+i);
            error.after(messages[i]);
        }
    }
}

function getStyles(styles)
{
    var output = '';
    for(i in styles)
        output += '<link rel="stylesheet" href="'+styles[i]+'" class="pageStyle" />';
    return output;
}

function getMessageList(messages)
{
    /*
        Converts a list of user notification messages to an unordered list
    */
    var output = '<ul>';
    for(i in messages)
        output += '<li>'+messages[i]+'</li>';
    output += '</ul>';
    return output;
}

function bindClick()
{
    $('#content a[rel]').unbind('click').click(function()
    {
        return loadPage(this);
    });
}

$.address.externalChange(function(event)
{
    var url = event.value.substring(1);
    if(url == "")
        url = 'index.php';
    loadPage(url, true);
});

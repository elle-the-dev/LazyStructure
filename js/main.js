var MESSAGE_SPEED = 500;
var messages = { errors: {}, successes: {} };

function loadPage(obj, inline)
{
    
    /*
        The jQuery address plugin does not work if the link is
        in the AJAX content area (main). This fixes that.
    */
    if(!inline)
        window.location='#/'+obj.rel.substring(8);

    var main = $('#main');
    main.addClass('loading');

    // Clears everything out so all the user sees is the loading animation
    $('#mainContent').css('opacity', '0.3');

    $.getJSON(obj, function(data)
    {
        $('#mainContent').css('opacity', '1');
        $('.pageStyle').remove();
        $('head').append(getStyles(data['styles']));
        main.html(data['markup'].toString());
        main.removeClass('loading');
        $('title').html(data['title'].toString());
    });
    return false;
}

function formSubmit(obj)
{
    var form = $(obj);
    $.post(obj.action, form.serialize(), function(data)
    {
        // Return data is JSON object string, so eval to get object
        var message = $.parseJSON(data);
        showAll(message);
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

function showAll(message)
{
    showErrors(message['errors']);
    showSuccesses(message['successes']);
    showFieldErrors(message['fieldErrors']);
}

function showErrors(messages)
{
    if(typeof messages != "undefined")
    {
        $('#success').css('display', 'none');
        var errors = $('#errors');
        errors.css('display', 'none');
        errors.html(getMessageList(messages));
        errors.fadeIn(MESSAGE_SPEED);
    }
}

function showSuccesses(messages)
{
    if(typeof messages != "undefined")
    {
        $('#error').css('display', 'none');
        var successes = $('#successes');
        successes.css('display', 'none');
        successes.html(getMessageList(messages));
        successes.fadeIn(MESSAGE_SPEED);
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

$.address.externalChange(function(event)
{
    var url = event.value.substring(1);
    if(url == "")
        url = 'index.php';
    loadPage(url, true);
});

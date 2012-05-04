function moveRelation(to, from)
{
    $('#'+to+' option[value="-1"]').remove();
    $('#'+from+' option[value="-1"]').remove();
    var ids = $('#'+from).val();
    var len = ids.length;
    for(var i=0;i<len;++i)
    {  
        var jObj = $('#'+from+' option[value="'+ids[i]+'"]');
        addOption(to, ids[i], jObj.html());
        jObj.remove();
    }  
}

function addOption(selectID, value, display)
{
    var obj = document.getElementById(selectID);
    obj.options[obj.options.length] = new Option(display, value);
}

function selectAll(selectID)
{
    var obj = document.getElementById(selectID);
    var len = obj.options.length;
    for(var i=0;i<len;++i)
    {  
        obj.options[i].selected = true;
    }  
}


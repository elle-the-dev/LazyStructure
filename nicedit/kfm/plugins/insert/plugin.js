PATH = '/LazyStructure/upload/';

function plugin_insert(){this.name="insert";this.title="insert file";this.category="main";this.mode=0;this.extensions="all";this.writable=2;this.doFunction=function(files){kfm_insertFile(files[0]);}
this.nocontextmenu=false;}
kfm_addHook(new plugin_insert());if(!window.ie){kfm_addHook(new plugin_insert(),{mode:1,title:"insert selected files",doFunction:function(files){kfm_insertFile();}});}

function kfm_insertFile(id)
{
    var imgExt = ['jpg','jpeg','gif','png','bmp'];
    var filename=File_getInstance(id).name;
    
    var pieces = filename.split('.');
    var fileExt = pieces[pieces.length-1].toLowerCase();
    if(jQuery.inArray(fileExt, imgExt) != -1)
        var html = '<img src="'+PATH+filename+'" alt="'+filename+'" />';
    else
        var html = '<a href="'+PATH+filename+'">'+filename+'</a>';
    opener.nicEditors.editors[0].selectedInstance.nicCommand('insertHTML', html);
    window.close();
}


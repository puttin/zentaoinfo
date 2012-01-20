/* Browse by module. */
function browseByModule()
{
    $('#treebox').removeClass('hidden');
    $('.divider').removeClass('hidden');
    $('#bymoduleTab').addClass('active');
    $('#createdbymeTab').removeClass('active');
    $('#postponedTab').removeClass('active');
    $('#mailtomeTab').removeClass('active');
    $('#allTab').removeClass('active');
    $('#bysearchTab').removeClass('active');
    $('#querybox').addClass('hidden');
}

$(function(){
	$("a.iframe").colorbox({width:600, height:350, iframe:true, transition:'none'});
    $('#' + browseType + 'Tab').addClass('active');
    if(browseType == "bysearch")search();
    
	/* If customed and the browse is ie6, remove the ie6.css. */
	if(customed && $.browser.msie && Math.floor(parseInt($.browser.version)) == 6)
	{
		$("#browsecss").attr('href', '');
	}
});

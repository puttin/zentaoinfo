function defaultChanged()
{
	if ($('#DefaultType').val() == 'USER_DEFINED') {
		$('#defaultValueBox').show("slow");
	}
	else {
		$('#defaultValueBox').hide("slow");
	}
}

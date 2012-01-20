function switchInfoLib(libID, module, method, extra)
{
	if(method != 'view' && method != 'edit')
	{
		link = createLink(module, method, "rootID=" + libID);
	}
	else
	{
		link = createLink(module, 'browse');
	}
	location.href=link;
}
/**
 * Load all fields.
 * 
 * @param  int $productID 
 * @access public
 * @return void
 */
function loadAll(libID)
{
    if(!changeLibConfirmed)
    {
         firstChoice = confirm(confirmChangeLib);
         changeLibConfirmed = true;    // Only notice the user one time.
    }
    if(changeLibConfirmed || firstChoice)
    {
        loadModuleMenu(libID); 
    }
}

/**
 * Load module menu.
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadModuleMenu(libID)
{
    link = createLink('info', 'ajaxGetOptionMenu', 'libID=' + libID);
    $('#moduleIdBox').load(link);
}

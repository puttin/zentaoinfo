/**
 * Load all fields. 
 * 
 * @param  int    $productID 
 * @access public
 * @return void
 */
function loadAll(libID)
{
    loadModuleMenu(libID);
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
    link = createLink('info', 'TreeAjaxGetOptionMenu', 'libID=' + libID);
    $('#moduleIdBox').load(link);
}

$(function() {
    $("#mailto").autocomplete(userList, { multiple: true, mustMatch: true});
})
function createRandomColor() {
	//16进制方式表示颜色0-F
	var arrHex = ["0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F"];
	var strHex = "#";
	var index;
	for(var i = 0; i < 6; i++) {
		//取得0-15之间的随机整数
		index = Math.round(Math.random() * 15);
		strHex += arrHex[index];
	}
	return strHex;
}
function changeColor(){
	var color = document.getElementById("highlight").value;
	var highlightLabel = document.getElementById("highlightLabel");
	if (color.length == 0){
		highlightLabel.style.color="black";
		highlightLabel.style.fontWeight="normal";
		highlightLabel.style.fontSize="100%";
	}
	else{
		highlightLabel.style.color=color;
		highlightLabel.style.fontWeight="bold";
		highlightLabel.style.fontSize="110%";
	}
}
function randomColor(){
	var color = createRandomColor();
	var highlightLabel = document.getElementById("highlightLabel");
	document.getElementById("highlight").value = color;
	highlightLabel.style.color=color;
	highlightLabel.style.fontWeight="bold";
	highlightLabel.style.fontSize="110%";
}
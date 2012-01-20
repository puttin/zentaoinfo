<?php 
	$this->app->loadLang('info',$exit = false);
?>
<script language='Javascript'>
	function scrollToFoot(){
		$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		$body.animate({scrollTop: $('p.a-center').offset().top}, 1000);
	}
	function thanksForUsing(){
		if (confirm(<?php echo '"'.$this->lang->info->welcome.$this->lang->info->gotoInfoIndex.'"';?>)){
			parent.location.href = <?php echo '"'.helper::createLink('info').'"';?>;
		}
	}
	window.onload = function(){ scrollToFoot();setTimeout(thanksForUsing,1100);};
</script>

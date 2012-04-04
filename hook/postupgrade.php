<?php 
	//目前由于uninstall不会删除数据库,所以install其实和upgrade差不多
	$this->app->loadLang('info',$exit = false);
	$this->loadModel('upgrade');
	$files=array();
	$prefix=$this->config->db->prefix;
	$versionChecks=array(
						'0.2'	=>'desc '.$prefix."info 'mailto'",
						'0.3'	=>'desc '.$prefix."infolib 'type'",
						'0.3.1'	=>'desc '.$prefix."infoasset 'use'",
						'0.4'	=>'desc '.$prefix."infoasset 'product'",
						);
	foreach ($versionChecks as $key => $checkStr){
		$test=$this->app->dbh->query($checkStr)->fetch(PDO::FETCH_OBJ);
		if (!$test->Field) {
			$file = $this->app->getModuleExtPath('extension','info') . 'db' . $this->app->getPathFix() . 'update' . $key . '.sql';
			if(file_exists($file))
			{
				$this->upgrade->execSQL($file);
			}
			else
			{
				echo js::alert($file.' NOT exist!');
			}
			$files[] = $file;
		}
	}
?>
<script language='Javascript'>
	function appendUpgradeFiles(){
		$("h3:last").after(<?php echo "'<ul>";foreach($files as $fileName){echo "<li>".addslashes($fileName)."</li>";}echo "</ul>'";?>);
	}
	function scrollToFoot(){
		$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		$body.animate({scrollTop: $('p.a-center').offset().top}, 1000);
	}
	function thanksForUsing(){
		if (confirm(<?php echo '"'.$this->lang->info->welcome.$this->lang->info->gotoInfoIndex.'"';?>)){
			parent.location.href = <?php echo '"'.helper::createLink('info').'"';?>;
		}
	}
	window.onload = function(){ appendUpgradeFiles();scrollToFoot();setTimeout(thanksForUsing,1100);};
</script>

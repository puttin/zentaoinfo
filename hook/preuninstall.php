<?php 
	$this->app->loadLang('info',$exit = false);
	$appRoot = $this->app->getAppRoot();
	$dir=$appRoot.'/module/extension/ext/info/hook/';
	$str=sprintf($this->lang->info->pleaseGoToDeletePreuninstall,$dir);
?>
<script language='Javascript'>
if(!confirm(<?php echo '"'.$this->lang->info->confirmUninstallPlugin.'"';?>))
{
	parent.location.href = <?php echo '"'.inlink('browse').'"';?>;
}
else
{
	alert(<?php echo "'".$str."'";?>);
	parent.location.href = <?php echo '"'.inlink('browse').'"';?>;
}
</script>
<?php 
	die();
?>

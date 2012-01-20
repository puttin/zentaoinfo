<?php include './header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script language='Javascript'>
changeLibConfirmed = false;
confirmChangeLib   = '<?php echo $lang->info->confirmChangeLib;?>';
</script>
<form method='post' enctype='multipart/form-data' target='hiddenwin'>
  <table class='table-1'> 
	<caption><?php echo $lang->info->edit;?></caption>
	<tr>
		<td class='rowhead'><?php echo $lang->info->lib;?></td>
		<td>
			<?php echo html::select('lib', $libs, $libID, "onchange=loadAll(this.value);");?>
		</td>
	</tr>
	<tr>
	  <th class='rowhead'><?php echo $lang->info->module;?></th>
	  <td><span id='moduleIdBox'><?php echo html::select('module', $moduleOptionMenu, $info->module, "class='select-3'");?></span></td>
	</tr>
	  <th class='rowhead'><?php echo $lang->info->title;?></th>
	  <td><?php echo html::input('title', $info->title, "class='text-1'");?></td>
	</tr>
	<tr>
	  <th class='rowhead'><?php echo $lang->info->keywords;?></th>
	  <td><?php echo html::input('keywords', $info->keywords, "class='text-1'");?></td>
	</tr>
	<tr id='contentBox'>
	  <th class='rowhead'><?php echo $lang->info->content;?></th>
	  <td><?php echo html::textarea('content', htmlspecialchars($info->content), "class='text-1' rows='8' style='width:90%; height:400px'");?></td>
	</tr>
	<tr>
	  <th class='rowhead'><?php echo $lang->info->digest;?></th>
	  <td><?php echo html::textarea('digest', $info->digest, "class='text-1' rows=3");?></td>
	</tr>
	<tr>
	  <th class='rowhead'><?php echo $lang->info->comment;?></th>
	  <td><?php echo html::textarea('comment','', "class='text-1' rows=3");?></td>
	</tr>
	<tr id='fileBox'>
	  <th class='rowhead'><?php echo $lang->info->files;?></th>
	  <td><?php echo $this->fetch('file', 'buildform', 'fileCount=2');?></td>
	</tr>  
	<tr>
	  <td colspan='2' class='a-center'>
		<?php echo html::submitButton() . html::resetButton() .html::hidden('editedCount', $info->editedCount+1);?>
	  </td>
	</tr>
  </table>
</form>
<?php include './footer.html.php';?>

<?php include './header.html.php';?>
<div id='titlebar'>
  <div id='main' <?php if($info->deleted) echo "class='deleted'";?>>INFO #<?php echo $info->id . $lang->colon . $info->title;?></div>
  <div>
	<?php
	$browseLink    = $app->session->infoList != false ? $app->session->infoList : inlink('browse', "libID=$info->lib");
	$params        = "infoID=$info->id";
	$copyParams    = "infoID=$info->id";
	if(!$info->deleted)
	{
		common::printLink('info', 'edit', $params, $lang->info->buttonEdit);
		//common::printLink('info', 'create', $copyParams, $lang->info->buttonCopy);
		common::printLink('info', 'delete', $params, $lang->delete, 'hiddenwin');
	}
	echo html::a($browseLink, $lang->goback);
	?>
  </div>
</div>

<table class='cont-rt5'>
  <tr valign='top'>
	<td>
		<?php if($info->digest){?>
			<fieldset>
				<legend><?php echo $lang->info->digest;?></legend>
				<div class='content'><?php echo str_replace('<p>[', '<p class="stepTitle">[', $info->digest);?></div>
			</fieldset>
		<?php }?>
		<fieldset>
			<legend><?php echo $lang->info->content;?></legend>
			<div class='content'><?php echo str_replace('<p>[', '<p class="stepTitle">[', $info->content);?></div>
		</fieldset>
		<?php echo $this->fetch('file', 'printFiles', array('files' => $info->files, 'fieldset' => 'true'));?>
		<?php include '../../common/view/action.html.php';?>
		<div class='a-center' style='font-size:16px; font-weight:bold'>
			<?php
			if(!$info->deleted)
			{
				common::printLink('info', 'edit', $params, $lang->info->buttonEdit);
				//common::printLink('info', 'create', $copyParams, $lang->info->buttonCopy);
				common::printLink('info', 'delete', $params, $lang->delete, 'hiddenwin');
			}
			echo html::a($browseLink, $lang->goback);
			?>
		</div>
	</td>
	<td class='divider'></td>
	<td class='side'>
	  <fieldset>
		<legend><?php echo $lang->info->legendBasicInfo;?></legend>
		<table class='table-1 a-left'>
		<tr valign='middle'>
			<th class='rowhead'><?php echo $lang->info->lib;?></th>
			<td><?php if(!common::printLink('info', 'browse', "libID=$info->lib", $libName)) echo $libName;?>
		</tr>
		  <tr>
			<th class='rowhead'><?php echo $lang->info->module;?></th>
			<td> 
			  <?php
			  foreach($modulePath as $key => $module)
			  {
				  if(!common::printLink('info', 'browse', "libID=$info->lib&moduleID=$module->id", $module->name)) echo $module->name;
				  if(isset($modulePath[$key + 1])) echo $lang->arrow;
			  }
			  ?>
			</td>
		  </tr>
		  <tr>
			<td class='rowhead'><?php echo $lang->info->editedCount;?></td>
			<td><?php echo $info->editedCount;?></td>
		  </tr>
		</table>
	  </fieldset>
	  <fieldset>
		<legend><?php echo $lang->info->legendLife;?></legend>
		<table class='table-1 a-left fixed'>
		  <tr>
			<th class='rowhead w-p20'><?php echo $lang->info->createdBy;?></th>
			<td> <?php echo $users[$info->createdBy] . $lang->at . $info->createdDate;?></td>
		  </tr>
		  <tr>
			<th class='rowhead'><?php echo $lang->info->lastEditedBy;?></th>
			<td><?php if($info->lastEditedBy) echo $users[$info->lastEditedBy] . $lang->at . $info->lastEditedDate?></td>
		  </tr>
		</table>
	  </fieldset>
	</td>
  </tr>
</table>
<?php include './footer.html.php';?>

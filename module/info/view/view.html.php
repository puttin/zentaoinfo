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
		if(common::hasPriv('info', 'edit')) echo html::a('#', $lang->comment, '', 'onclick=setComment()'). ' ';
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
		<?php if($info->digest):?>
		<fieldset>
			<legend><?php echo $lang->info->digest;?></legend>
			<div class='content'><?php echo $info->digest;?></div>
		</fieldset>
		<?php endif;?>
		<fieldset>
			<legend><?php echo $lang->info->content;?></legend>
			<div class='content'><?php echo $info->content;?></div>
		</fieldset>
		<?php echo $this->fetch('file', 'printFiles', array('files' => $info->files, 'fieldset' => 'true'));?>
		<?php include '../../common/view/action.html.php';?>
		<div class='a-center' style='font-size:16px; font-weight:bold'>
			<?php
			if(!$info->deleted)
			{
				if(common::hasPriv('info', 'edit')) echo html::a('#', $lang->comment, '', 'onclick=setComment()'). ' ';
				common::printLink('info', 'edit', $params, $lang->info->buttonEdit);
				//common::printLink('info', 'create', $copyParams, $lang->info->buttonCopy);
				common::printLink('info', 'delete', $params, $lang->delete, 'hiddenwin');
			}
			echo html::a($browseLink, $lang->goback);
			?>
		</div>
		<div id='comment' class='hidden'>
		<fieldset>
			<legend><?php echo $lang->comment;?></legend>
			<form method='post' enctype='multipart/form-data'  action='<?php echo inlink('edit', "infoID=$info->id&comment=true")?>'>
				<table align='center'>
					<tr><?php echo html::textarea('comment', '',"rows='5' class='w-p100'");?></tr>
					<tr><td><?php echo html::submitButton() . html::resetButton();?></td></tr>
				</table>
			</form>
		</fieldset>
	  </div>
	</td>
	<td class='divider'></td>
	<td class='side'>
		<fieldset>
		<legend><?php echo $lang->info->legendBasicInfo;?></legend>
		<table class='table-1 a-left'>
			<tr valign='middle'>
				<th class='rowhead'><?php echo $lang->info->lib;?></th>
				<td><?php if(!common::printLink('info', 'browse', "libID=$info->lib", $libName)) echo $libName;?></td>
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
			<tr>
				<td class='rowhead w-p20'><?php echo $lang->info->mailto;?></td>
				<td><?php $mailto = explode(',', str_replace(' ', '', $info->mailto)); foreach($mailto as $account) echo ' ' . $users[$account]; ?></td>
			</tr>
			<tr>
			<th class='rowhead'><?php echo $lang->info->deadline;?></th>
			<td>
				<?php
					echo $info->deadline;
					if(isset($info->delay)) printf($lang->info->delayWarning, $info->delay);
				?>
			</td>
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
		<?php if($relatedStoryArray):?>
		<fieldset>
			<legend><?php echo $lang->info->relatedStory;?></legend>
			<table class='table-1 a-left fixed'>
				<tr>
					<td>
					<?php
					foreach($relatedStoryArray as $key => $value)
					{
						echo '<span class="nobr">' . html::a($this->createLink('story', 'view', "storyID=$key"), "#$key $value") . '</span><br />';
					}
					?>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php endif;?>
		<?php if($relatedTaskArray):?>
		<fieldset>
			<legend><?php echo $lang->info->relatedTask;?></legend>
			<table class='table-1 a-left fixed'>
				<tr>
					<td>
					<?php
					foreach($relatedTaskArray as $key => $value)
					{
						echo '<span class="nobr">' . html::a($this->createLink('task', 'view', "taskID=$key"), "#$key $value") . '</span><br />';
					}
					?>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php endif;?>
		<?php if($relatedBugArray):?>
		<fieldset>
			<legend><?php echo $lang->info->relatedBug;?></legend>
			<table class='table-1 a-left fixed'>
				<tr>
					<td>
					<?php
					foreach($relatedBugArray as $key => $value)
					{
						echo '<span class="nobr">' . html::a($this->createLink('bug', 'view', "bugID=$key"), "#$key $value") . '</span><br />';
					}
					?>
					</td>
				</tr>
			</table>
		</fieldset>
		<?php endif;?>
	</td>
	</tr>
</table>
<?php include './footer.html.php';?>

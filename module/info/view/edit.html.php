<?php include './header.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script language='Javascript'>
userList = "<?php echo join(',', array_keys($users));?>".split(',');
changeLibConfirmed = false;
confirmChangeLib   = '<?php echo $lang->info->confirmChangeLib;?>';
</script>
<form method='post' enctype='multipart/form-data' target='hiddenwin'>
	<div id='titlebar'>
		<div id='main'>
			INFO #<?php echo $info->id . $lang->colon;?>
			<?php echo html::input('title', str_replace("'","&#039;",$info->title), 'class=text-1');?>
		</div>
		<div><?php echo html::submitButton()?></div>
	</div>
	
	<table class='cont-rt5'>
		<tr valign='top'>
			<td>
				<table class='table-1 bd-none'>
					<tr class='bd-none'><td class='bd-none'>
						<fieldset>
							<legend><?php echo $lang->info->content;?></legend>
							<?php echo html::textarea('content', htmlspecialchars($info->content), "rows='12' class='area-1'");?>
						</fieldset>
						<fieldset>
							<legend><?php echo $lang->info->digest;?></legend>
							<?php echo html::textarea('digest', $info->digest, "rows='3' class='area-1'");?>
						</fieldset>
						<fieldset>
							<legend><?php echo $lang->info->comment;?></legend>
							<?php echo html::textarea('comment', '', "rows='6' class='area-1'");?>
						</fieldset>
						<fieldset>
							<legend><?php echo $lang->info->files;?></legend>
							<?php echo $this->fetch('file', 'buildform', 'filecount=2');?>
						</fieldset>
						<div class='a-center'>
							<?php 
							echo html::submitButton().html::resetButton().html::hidden('editedCount', $info->editedCount+1);
							$browseLink = $app->session->infoList != false ? $app->session->infoList : inlink('browse', "libID=$info->lib");
							echo html::linkButton($lang->goback, $browseLink);
							?>
						</div>
					</td></tr>
				</table>
				<?php include '../../common/view/action.html.php';?>
			</td>
			<td class='divider'></td>
			<td class='side'>
				<fieldset>
					<legend><?php echo $lang->info->legendBasicInfo;?></legend>
					<table class='table-1 a-left' cellpadding='0' cellspacing='0'>
						<tr>
							<td class='rowhead'><?php echo $lang->info->lib;?></td>
							<td>
								<?php echo html::select('lib', $libs, $libID, "onchange=loadAll(this.value);");?>
							</td>
						</tr>
						<tr>
							<td class='rowhead'><?php echo $lang->info->module;?></td>
							<td><span id='moduleIdBox'><?php echo html::select('module', $moduleOptionMenu, $info->module);?></span></td>
						</tr>
						<?php if(common::hasPriv('info', 'HighlightAndStickie')):?>
						<tr>
							<td class="rowhead"><?php echo $lang->info->Stickie;?></td>
							<td>
								<?php echo html::radio('stickie',array("0"=>$lang->info->StickieLable[0],"1"=>$lang->info->StickieLable[1],"2"=>$lang->info->StickieLable[2]),$info->stickie);?>
							</td>
						</tr>
						<tr>
							<td class="rowhead"><?php echo $lang->info->Highlight;?></td>
							<td>
							<?php
								$highlight='';$highlightLabelStyle='';
								if ($info->highlight) {$highlight=$info->highlight;$highlightLabelStyle='style="color: '.$highlight.';font-weight: bold;font-size: 110%;" ';}
								echo html::input('highlight',$highlight,'class="w-60px" onchange="changeColor()"');
								echo '<span id="highlightLabel" '.$highlightLabelStyle.'onclick="randomColor()">'.$lang->info->highlightLabel.'</span>';
								echo $lang->info->highlightTryMe;
							?>
							</td>
						</tr>
						<?php endif;?>
						<tr>
							<td class='rowhead'><?php echo $lang->info->lblMailto;?></td>
							<td> <?php echo html::input('mailto', $info->mailto, 'class=text-3');?></td>
						</tr>
						<tr>
							<th class='rowhead'><?php echo $lang->info->deadline;?></th>
							<td><?php echo html::input('deadline', $info->deadline, "class='text-3 date'");?></td>
						</tr>
						<tr>
							<td class='rowhead'><?php echo $lang->info->keywords;?></th>
							<td><?php echo html::input('keywords', $info->keywords, "class='text-3'");?></td>
						</tr>
						<tr>
							<td class='rowhead'><?php echo $lang->info->pri;?></td>
							<td><?php echo html::select('pri', $lang->info->priList, $info->pri, 'class=select-1');?></td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend><?php echo $lang->info->relatedStory;?></legend>
					<table class='table-1 a-left fixed'>
						<tr>
							<td class='rowhead w-p20'><?php echo $lang->info->relatedStory;?></td>
							<td><?php echo html::input('relatedStory', $info->relatedStory, 'class=text-3');?> </td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend><?php echo $lang->info->relatedTask;?></legend>
					<table class='table-1 a-left fixed'>
						<tr>
							<td class='rowhead w-p20'><?php echo $lang->info->relatedTask;?></td>
							<td><?php echo html::input('relatedTask', $info->relatedTask, 'class=text-3');?> </td>
						</tr>
					</table>
				</fieldset>
				<fieldset>
					<legend><?php echo $lang->info->relatedBug;?></legend>
					<table class='table-1 a-left fixed'>
						<tr>
							<td class='rowhead w-p20'><?php echo $lang->info->relatedBug;?></td>
							<td><?php echo html::input('relatedBug', $info->relatedBug, 'class=text-3');?> </td>
						</tr>
					</table>
				</fieldset>
			</td>
		</tr>
	</table>
</form>
<?php include './footer.html.php';?>

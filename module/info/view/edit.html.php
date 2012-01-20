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
		<tr id='contentBox'>
			<th class='rowhead'><?php echo $lang->info->content;?></th>
			<td><?php echo html::textarea('content', htmlspecialchars($info->content), "class='text-1' rows='8' style='width:90%; height:400px'");?></td>
		</tr>
		<?php if(common::hasPriv('info', 'HighlightAndStickie')):?>
			<tr>
				<th class="rowhead"><?php echo $lang->info->Stickie;?></th>
				<td>
					<?php echo html::radio('stickie',array("0"=>$lang->info->StickieLable[0],"1"=>$lang->info->StickieLable[1],"2"=>$lang->info->StickieLable[2]),$info->stickie);?>
				</td>
			</tr>
			<tr>
				<th class="rowhead"><?php echo $lang->info->Highlight;?></th>
				<td>
					<?php
						$highlight='';$highlightLabelStyle='';
						if ($info->highlight) {$highlight=$info->highlight;$highlightLabelStyle='style="color: '.$highlight.';font-weight: bold;font-size: 110%;" ';}
						echo html::input('highlight',$highlight,'class="text-2" onchange="changeColor()"');
						echo '<span id="highlightLabel" '.$highlightLabelStyle.'onclick="randomColor()">'.$lang->info->highlightLabel.'</span>';
						echo $lang->info->highlightTryMe;
					?>
				</td>
			</tr>
		<?php endif;?>
		<tr>
			<th class='rowhead'><?php echo $lang->info->deadline;?></th>
			<td><?php echo html::input('deadline', $info->deadline, "class='text-3 date'");?></td>
		</tr>
		<tr>
			<th class='rowhead'><nobr><?php echo $lang->info->lblMailto;?></nobr></th>
			<td> <?php echo html::input('mailto', $info->mailto, 'class=text-4');?> </td>
		</tr>
		<tr>
			<td class='rowhead'><?php echo $lang->info->pri;?></td>
			<td><?php echo html::select('pri', $lang->info->priList, $info->pri, 'class=select-3');?>
		</tr>
		<tr>
			<th class='rowhead'><?php echo $lang->info->keywords;?></th>
			<td><?php echo html::input('keywords', $info->keywords, "class='text-1'");?></td>
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

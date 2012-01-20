<?php include './header.html.php';?>
<?php include '../../common/view/autocomplete.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<script language='Javascript'>
userList = "<?php echo join(',', array_keys($users));?>".split(',');
</script>
<form method='post' enctype='multipart/form-data' target='hiddenwin'>
	<table class='table-1'> 
		<caption><?php echo $lang->info->create;?></caption>
		<tr>
			<th class='rowhead'><?php echo $lang->info->lib;?></th>
			<td>
				<?php echo html::select('lib', $libs, $libID, "onchange='loadAll(this.value)' class='select-2'");?>
			</td>
		 </tr> 
		<tr>
			<th class='rowhead'><?php echo $lang->info->module;?></th>
			<td><span id='moduleIdBox'><?php echo html::select('module', $moduleOptionMenu, $moduleID, "class='select-3'");?></span></td>
		</tr>
		<tr>
			<th class='rowhead'><?php echo $lang->info->title;?></th>
			<td><?php echo html::input('title', '', "class='text-1'");?></td>
		</tr> 
		<tr id='contentBox'>
			<th class='rowhead'><?php echo $lang->info->content;?></th>
			<td><?php echo html::textarea('content', '', "class='area-1' style='width:90%; height:200px'");?></td>
		</tr>
		<?php if(common::hasPriv('info', 'HighlightAndStickie')):?>
			<tr>
				<th class="rowhead"><?php echo $lang->info->Stickie;?></th>
				<td>
					<?php echo html::radio('stickie',array("0"=>$lang->info->StickieLable[0],"1"=>$lang->info->StickieLable[1],"2"=>$lang->info->StickieLable[2]),'0');?>
				</td>
			</tr>
			<tr>
				<th class="rowhead"><?php echo $lang->info->Highlight;?></th>
				<td>
					<?php
						echo html::input('highlight','','class="text-2" onchange="changeColor()"');
						echo '<span id="highlightLabel" onclick="randomColor()">'.$lang->info->highlightLabel.'</span>';
						echo $lang->info->highlightTryMe;
					?>
				</td>
			</tr>
		<?php endif;?>
		<tr>
			<th class='rowhead'><?php echo $lang->info->deadline;?></th>
			<td><?php echo html::input('deadline', '', "class='text-3 date'");?></td>
		</tr>
		<tr>
			<th class='rowhead'><nobr><?php echo $lang->info->lblMailto;?></nobr></th>
			<td> <?php echo html::input('mailto', $mailto, 'class=text-4');?> </td>
		</tr>
		<tr>
			<td class='rowhead'><?php echo $lang->info->pri;?></td>
			<td><?php echo html::select('pri', $lang->info->priList, '0', 'class=select-3');?>
		</tr>
		<tr>
			<th class='rowhead'><?php echo $lang->info->keywords;?></th>
			<td><?php echo html::input('keywords', '', "class='text-1'");?></td>
		</tr>
		<tr>
			<th class='rowhead'><?php echo $lang->info->digest;?></th>
			<td><?php echo html::textarea('digest', '', "class='text-1' rows=3");?></td>
		</tr>
		<tr id='fileBox'>
			<th class='rowhead'><?php echo $lang->info->files;?></th>
			<td><?php echo $this->fetch('file', 'buildform', 'fileCount=2');?></td>
		</tr>
		<tr>
			<td colspan='2' class='a-center'><?php echo html::submitButton() . html::resetButton();?></td>
		</tr>
	</table>
</form>
<?php include './footer.html.php';?>

<?php include '../../common/view/header.lite.html.php';?>
<form method='post'	action='<?php echo $actionType=='create'?$this->createLink('custom', 'create', "moduleType=$moduleType"):$this->createLink('custom', 'edit', "moduleType=$moduleType&field=$Field");?>'>
	<table align='center' class='table-3 f-14px'>
		<caption><?php echo $lang->custom->create;?></caption>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Field;?></th>
			<td><?php echo html::input('Field', $Field, "class='text-2'");?></td>
		</tr>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Type;?></th>
			<td><?php echo html::selectGroup('Type',$lang->custom->TypeList,$Type,"class='select-2'");?></td>
		</tr>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Length;?></th>
			<td><?php echo html::input('Length', $Length, "class='text-2'");?></td>
		</tr>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Default;?></th>
			<td><?php echo html::select('DefaultType',$lang->custom->DefaultList,$DefaultType,"class='select-2' onchange='defaultChanged()'");?></td>
		</tr>
		<tr id='defaultValueBox' class='<?php if($DefaultType !='USER_DEFINED') echo 'hidden';?>'>
			<th></th>
			<td><?php echo html::input('DefaultValue', $DefaultValue, "class='text-2'");?></td>
		</tr>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Null;?></th>
			<td><?php echo html::checkbox('Null',array('NULL'=>''),$Null, "");?></td>
		</tr>
		<tr>
			<th class='w-100'><?php echo $lang->custom->Comment;?></th>
			<td><?php echo html::input('Comment', $Comment, "class='text-2'");?></td>
		</tr>
		<tr>
			<td colspan='2' class='a-center'><?php echo html::submitButton().html::hidden('oldField', $oldField);?></td>
		</tr>
	</table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>

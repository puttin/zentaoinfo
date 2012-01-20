<?php include '../../common/view/header.lite.html.php';?>
<form method='post'>
	<table class='table-1'> 
		<caption><?php echo $lang->$type->editLib;?></caption>
		<tr>
			<th class='rowhead'><?php echo $lang->$type->libName;?></th>
			<td><?php echo html::input('name', $libName, "class='text-1'");?></td>
		</tr>
		<?php if (!$defaultLib):?>
		<tr>
			<th class='rowhead'><?php echo $lang->$type->libDefault;?></th>
			<td><input type='checkbox' name='defaultlib' <?php if($defaultLib) echo "checked";?> /></td>
		</tr>
		<?php endif;?>
		<tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
	</table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>

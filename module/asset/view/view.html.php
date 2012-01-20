<?php include '../../info/view/header.html.php';?>
<div id='titlebar'>
	<div id='main' <?php if($asset->deleted) echo "class='deleted'";?>>ASSET #<?php echo $asset->id . $lang->colon . $asset->hostname;?></div>
	<div>
	<?php
	$browseLink    = $app->session->assetList != false ? $app->session->assetList : inlink('browse', "libID=$asset->lib");
	$params        = "assetID=$asset->id";
	$copyParams    = "libID=$libID&moduleID=$moduleID&extra=assetID=$asset->id";
	if(!$asset->deleted)
	{
		common::printLink('asset', 'edit', $params, $lang->asset->buttonEdit);
		common::printLink('asset', 'create', $copyParams, $lang->asset->buttonCopy);
		common::printLink('asset', 'delete', $params, $lang->delete, 'hiddenwin');
	}
	echo html::a($browseLink, $lang->goback);
	?>
	</div>
</div>

<table class='cont-rt5'>
	<tr valign='top'>
		<td>
			<fieldset>
				<legend><?php echo $lang->asset->legendBasicInfo;?></legend>
				<table class='table-1 a-left fixed'>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->hostname;?></th>
						<td> <?php echo $asset->hostname;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->address;?></th>
						<td> <?php echo $asset->address;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->extendaddress;?></th>
						<td> <?php echo $asset->extendaddress;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->os;?></th>
						<td> <?php echo $lang->asset->osList[$asset->os];?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->username;?></th>
						<td> <?php echo $asset->username;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->password;?></th>
						<td> <?php echo $asset->password;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->status;?></th>
						<td> <?php echo $lang->asset->statusList[$asset->status];?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->duty;?></th>
						<td> <?php echo $users[$asset->duty];?></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><?php echo $lang->asset->legendExtendInfo;?></legend>
				<table class='table-1 a-left fixed'>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->lib;?></th>
						<td><?php if(!common::printLink('asset', 'browse', "libID=$asset->lib", $libName)) echo $libName;?></td>
					</tr>
					<tr>
						<th class='rowhead'><?php echo $lang->asset->module;?></th>
						<td> 
							<?php
							foreach($modulePath as $key => $module)
							{
								if(!common::printLink('asset', 'browse', "libID=$asset->lib&moduleID=$module->id", $module->name)) echo $module->name;
								if(isset($modulePath[$key + 1])) echo $lang->arrow;
							}
							?>
						</td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->position;?></th>
						<td> <?php echo $asset->position;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->devicenumber;?></th>
						<td> <?php echo $asset->devicenumber;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->rootusername;?></th>
						<td> <?php echo $asset->rootusername;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->rootpassword;?></th>
						<td> <?php echo $asset->rootpassword;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->codeversion;?></th>
						<td> <?php echo $asset->codeversion;?></td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td class='divider'></td>
		<td class='w-p50'>
			<fieldset>
				<legend><?php echo $lang->asset->legendIntrinsicInfo;?></legend>
				<table class='table-1 a-left fixed'>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->name;?></th>
						<td> <?php echo $asset->name;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->serial;?></th>
						<td> <?php echo $asset->serial;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->model;?></th>
						<td> <?php echo $asset->model;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->cpu;?></th>
						<td> <?php echo $asset->cpu;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->memory;?></th>
						<td> <?php echo $asset->memory;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->disk;?></th>
						<td> <?php echo $asset->disk;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->graphics;?></th>
						<td> <?php echo $asset->graphics;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->price;?></th>
						<td> <?php echo $asset->price;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->netvalue;?></th>
						<td> <?php echo $asset->netvalue;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->code;?></th>
						<td> <?php echo $asset->code;?></td>
					</tr>
				</table>
			</fieldset>
			<fieldset>
				<legend><?php echo $lang->asset->legendLendInfo;?></legend>
				<table class='table-1 a-left fixed'>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->from;?></th>
						<td> <?php echo $asset->from;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->registdate;?></th>
						<td> <?php echo $asset->registdate;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->lend;?></th>
						<td> <?php echo $users[$asset->lend];?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->lenddate;?></th>
						<td> <?php echo $asset->lenddate;?></td>
					</tr>
					<tr>
						<th class='rowhead w-p20'><?php echo $lang->asset->returndate;?></th>
						<td> <?php echo $asset->returndate;?></td>
					</tr>
				</table>
			</fieldset>
		</td>
	</tr>
</table>
<?php if($asset->assetcomment or $asset->use):?>
<fieldset>
	<legend><?php echo $lang->asset->legendCommentInfo;?></legend>
		<table class='table-3 a-left fixed'>
			<tr>
				<th class='rowhead w-p20'><?php echo $lang->asset->use;?></th>
				<td><?php if($asset->use) echo $asset->use;?></td>
			</tr>
			<tr>
				<th class='rowhead w-p20'><?php echo $lang->asset->lastEditedBy;?></th>
				<td><?php if($asset->lastEditedBy) echo $users[$asset->lastEditedBy] . $lang->at . $asset->lastEditedDate?></td>
			</tr>
		</table>
	<div class='content'><?php echo $asset->assetcomment;?></div>
</fieldset>
<?php endif;?>
<?php include '../../common/view/action.html.php';?>
<div class='a-center' style='font-size:16px; font-weight:bold'>
	<?php
	if(!$asset->deleted)
	{
		common::printLink('asset', 'edit', $params, $lang->asset->buttonEdit);
		common::printLink('asset', 'create', $copyParams, $lang->asset->buttonCopy);
		common::printLink('asset', 'delete', $params, $lang->delete, 'hiddenwin');
	}
	echo html::a($browseLink, $lang->goback);
	?>
</div>
<?php include '../../info/view/footer.html.php';?>

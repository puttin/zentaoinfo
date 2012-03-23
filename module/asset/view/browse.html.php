<?php include '../../info/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<script language='Javascript'>
var browseType = '<?php echo $browseType;?>';
var moduleID   = '<?php echo $moduleID;?>';
var customed   = <?php echo (int)$customed;?>;
</script>

<div id='featurebar'>
	<div class='f-left'>
		<?php
			if ($libID){
				echo "<span id='bymoduleTab' onclick=\"browseByModule('$browseType')\"><a href='#'>" . $lang->asset->bymodule . "</a></span> ";
				echo "<span id='mydutyTab'>". html::a($this->createLink('asset', 'browse', "libID=$libID&moduleID=$moduleID&browseType=myduty&param=0"),$lang->asset->myduty). "</span>";
				echo "<span id='lendtomeTab'>" . html::a($this->createLink('asset', 'browse', "libID=$libID&moduleID=$moduleID&browseType=lendtome&param=0"), $lang->asset->lendtome) . "</span>";
			}
			echo "<span id='allTab'>". html::a($this->createLink('asset', 'browse', "libID=$libID&moduleID=$moduleID&browseType=all"),$lang->asset->allInfos). "</span>";
		?>
		<span id='bysearchTab'><a href='#'><span class='icon-search'></span><?php echo $lang->asset->searchInfo;?></a></span>
	</div>
	<div class='f-right'>
	<?php common::printLink('asset', 'export', "libID=$libID&orderBy=$orderBy", $lang->export, '', 'class="export"'); ?>
	<?php common::printLink('asset', 'customFields', '', $lang->asset->customFields, '', "class='iframe'"); ?>
	<?php common::printLink('asset', 'create', "libID=$libID&moduleID=$moduleID", $lang->asset->create); ?>
	</div>
</div>
<div id='querybox' class='<?php if($browseType !='bysearch') echo 'hidden';?>'><?php echo $searchForm;?></div>
<?php if($customed){include 'browse.custom.html.php'; exit;}?>
<table class='cont-lt2'>
	<tr valign='top'>
		<td class='side <?php echo $treeClass;?>' id='treebox'>
			<div class='box-title'><?php echo $lang->asset->module;?></div>
			<div class='box-content'>
			<?php echo $moduleTree;?>
			<div class='a-right'>
				<?php if(common::hasPriv('info', 'TreeManage')) common::printLink('info', 'treemanage', "rootID=$libID&module=0&type=asset", $lang->tree->manage);?>
			</div>
			</div>
		</td>
		<td class='divider <?php echo $treeClass;?>'></td>
		<td>
			 <?php $vars = "libID=$libID&moduleID=$moduleID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
			<table class='table-1 fixed colored tablesorter datatable'>
				<thead>
				<tr class='colhead'>
					<th class='w-id'> <?php common::printOrderLink('id',$orderBy, $vars, $lang->idAB);?></th>
					<th class='w-100px'> <?php common::printOrderLink('hostname',$orderBy, $vars, $lang->asset->hostname);?></th>
					<th class='w-120px'> <?php common::printOrderLink('address',$orderBy, $vars, $lang->asset->address);?></th>
					
					<th class='w-120px'> <?php common::printOrderLink('username',$orderBy, $vars, $lang->asset->username);?></th>
					<th class='w-120px'> <?php common::printOrderLink('password',$orderBy, $vars, $lang->asset->password);?></th>
					
					<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
					<th class='w-60px'>  <?php common::printOrderLink('status', $orderBy, $vars, $lang->asset->status);?></th>
					<th class='w-user'>  <?php common::printOrderLink('duty', $orderBy, $vars, $lang->asset->duty);?></th>
					<th class='w-60px'>  <?php common::printOrderLink('codeversion', $orderBy, $vars, $lang->asset->codeversion);?></th>
					<th class='w-60px'>  <?php common::printOrderLink('module', $orderBy, $vars, $lang->asset->module);?></th>
					<th class='w-60px'>  <?php common::printOrderLink('use', $orderBy, $vars, $lang->asset->use);?></th>
					<?php endif;?>
				</tr>
				</thead>
			<tbody>
			<?php foreach($assets as $asset):?>
			<?php $classduty = $asset->duty == $app->user->account ? 'style=color:red' : '';?>
				<?php $assetLink = inlink('view', "assetID=$asset->id");?>
				<tr class='a-center'>
					<td class='linkbox '><?php echo html::a($assetLink, sprintf('%03d', $asset->id));?></td>
					<td class='linkbox '><?php echo html::a($assetLink, $asset->hostname);?></td>
					<td><?php echo $asset->address?></td>
					<td><?php echo $asset->username;?></td>
					<td><?php echo $asset->password;?></td>
					
					<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
					<td<?php echo ' class="'.'status'.$asset->status.'"'?>><?php echo $lang->asset->statusList[$asset->status]?></td>
					<td <?php echo $classduty;?>><?php echo $users[$asset->duty];?></td>
					<td><?php echo $asset->codeversion;?></td>
					<td><?php echo $asset->module;?></td>
					<td><?php echo $asset->use;?></td>
					<?php endif;?>
				</tr>
			<?php endforeach;?>
			</tbody>
			<tfoot>
				<tr>
					<?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 10 : 5;?>
					<td colspan='<?php echo $columns;?>'>
						<div class='f-left'>
						</div>
						<div class='f-right'>
							<?php $pager->show();?>
						</div>
					</td>
				</tr>
			</tfoot>
			</table>
		</td>
	</tr>
</table> 

<?php include '../../info/view/footer.html.php';?>

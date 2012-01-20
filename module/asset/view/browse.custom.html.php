<table class='cont-lt1'>
	<tr valign='top'>
		<td class='side <?php echo $treeClass;?>' id='treebox'>
			<div class='box-title'><?php echo $lang->asset->module;?></div>
			<div class='box-content'>
			<?php echo $moduleTree;?>
			<div class='a-right'>
				<?php if(common::hasPriv('info', 'TreeManage')) common::printLink('info', 'TreeManage', "rootID=$libID&module=0&type=asset", $lang->tree->manage);?>
			</div>
			</div>
		</td>
		<td class='divider'></td>
		<td>
			<?php $vars = "libID=$libID&moduleID=$moduleID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
			<table class='table-1 fixed colored tablesorter datatable'>
				<thead>
				<tr class='colhead'>
					<?php foreach($customFields as $fieldName):?>
						<?php
							if(preg_match('/^id$/i', $fieldName))
							{
								echo "<th class='w-id'>"; common::printOrderLink('id',$orderBy, $vars, $lang->idAB);echo "</th>";
							}
							elseif(preg_match('/^hostname$/i', $fieldName))
							{
								echo "<th class='w-100px'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo "</th>";
							}
							elseif(preg_match('/^(address|extendaddress|username|password)$/i', $fieldName))
							{
								echo "<th class='w-120px'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo "</th>";
							}
							elseif(preg_match('/^(os|status)$/i', $fieldName))
							{
								echo "<th class='w-60px'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo "</th>";
							}
							elseif(preg_match('/^(createdBy|lastEditedBy|duty|lend)$/i', $fieldName))
							{
								echo "<th class='w-user'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo "</th>";
							}
							elseif(preg_match('/^(createdDate|lastEditedDate|registdate|lenddate|returndate)$/i', $fieldName))
							{
								echo "<th class='w-date'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo "</th>";
							}
							else{
								echo '<th>'; common::printOrderLink($fieldName, $orderBy, $vars, $lang->asset->$fieldName); echo '</th>';
							}
						?>
					<?php endforeach;?>
				</tr>
				</thead>
				<tbody>
				<?php foreach($assets as $asset):?>
				<?php $infoLink = inlink('view', "assetID=$asset->id");?>
				<tr class='a-center'>
					<?php foreach($customFields as $fieldName):?>
						<?php 
						if(preg_match('/^(id|hostname)$/i', $fieldName))
						{
							echo "<td class='linkbox'>";
							echo html::a($infoLink, $asset->$fieldName);
							echo "</td>";
						}
						elseif(preg_match('/^(createdBy|lastEditedBy|duty|lend)$/i', $fieldName))
						{
							$class = $asset->$fieldName == $app->user->account ? ' style=color:red' : '';
							echo "<td".$class.">";
							echo $users[$asset->$fieldName];
							echo "</td>";
						}
						elseif(preg_match('/^(createdDate|lastEditedDate)$/i', $fieldName))
						{
							echo "<td>";
							echo substr($asset->$fieldName, 5, 11);
							echo "</td>";
						}
						elseif(preg_match('/^os$/i', $fieldName))
						{
							echo "<td>";
							$key = $fieldName . 'List';
							$list = $lang->asset->$key;
							echo $list[$asset->$fieldName];
							echo "</td>";
						}
						elseif(preg_match('/^status$/i', $fieldName))
						{
							echo '<td class="'.'status'.$asset->status.'">';
							$key = $fieldName . 'List';
							$list = $lang->asset->$key;
							echo $list[$asset->$fieldName];
							echo "</td>";
						}
						else
						{
							echo "<td>";
							echo !($asset->$fieldName == '0') ? $asset->$fieldName : '';
							echo "</td>";
						}
						?>
					<?php endforeach;?>
				</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot><tr><td colspan='<?php echo count($customFields);?>'><?php $pager->show();?></td></tr></tfoot>
			</table>
		</td>
	</tr>
</table>
<?php include '../../info/view/footer.html.php';?>

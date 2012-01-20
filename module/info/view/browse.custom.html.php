<table class='cont-lt1'>
	<tr valign='top'>
		<td class='side <?php echo $treeClass;?>' id='treebox'>
			<div class='box-title'><?php echo $lang->info->module;?></div>
			<div class='box-content'>
			<?php echo $moduleTree;?>
			<div class='a-right'>
				<?php if(common::hasPriv('info', 'TreeManage')) common::printLink('info', 'TreeManage', "rootID=$libID", $lang->tree->manage);?>
			</div>
			</div>
		</td>
		<td class='divider'></td>
		<td>
			<?php $vars = "libID=$libID&moduleID=$moduleID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
			<table class='table-1 colored tablesorter datatable'>
				<thead>
				<tr class='colhead'>
					<?php foreach($customFields as $fieldName):?>
						<?php
							if(preg_match('/^id$/i', $fieldName))
							{
								echo "<th class='w-id'>"; common::printOrderLink('id',$orderBy, $vars, $lang->idAB);echo "</th>";
							}
							elseif(preg_match('/^pri$/i', $fieldName))
							{
								echo "<th class='w-pri'>"; common::printOrderLink('pri', $orderBy, $vars, $lang->priAB);echo "</th>";
							}
							elseif(preg_match('/^(createdBy|lastEditedBy)$/i', $fieldName))
							{
								echo "<th class='w-user'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->info->$fieldName); echo "</th>";
							}
							elseif(preg_match('/^(createdDate|lastEditedDate)$/i', $fieldName))
							{
								echo "<th class='w-date'>"; common::printOrderLink($fieldName, $orderBy, $vars, $lang->info->$fieldName); echo "</th>";
							}
							else{
								echo '<th>'; common::printOrderLink($fieldName, $orderBy, $vars, $lang->info->$fieldName); echo '</th>';
							}
						?>
					<?php endforeach;?>
					<th class='w-70px {sorter:false}'><nobr><?php echo $lang->actions;?></nobr></th>
				</tr>
				</thead>
				<tbody>
				<?php foreach($infos as $info):?>
				<?php $infoLink = inlink('view', "infoID=$info->id");?>
				<tr class='a-center'>
					<?php foreach($customFields as $fieldName):?>
						<?php 
						if(preg_match('/^id$/i', $fieldName))
						{
							echo "<td class='linkbox'>";
							echo html::a($infoLink, $info->$fieldName);
							echo "</td>";
						}
						elseif(preg_match('/^title$/i', $fieldName)){
							$class = 'stickie' . $info->stickie;
							$highlight=$info->highlight;
							$title=$highlight ? '<a style="font-weight: bold;font-size: 110%;color: '.$highlight.';" href="'.$infoLink.'" >'.$info->title.'</a>' : html::a($infoLink, $info->title);
							echo "<td class='a-left nobr'>";
							echo "<span class='$class'>{$lang->info->StickieList[$info->stickie]} </span>" . $title;
							echo "</td>";
						}
						elseif(preg_match('/^(createdBy|lastEditedBy)$/i', $fieldName))
						{
							$class = $info->$fieldName == $app->user->account ? ' style=color:red' : '';
							echo "<td".$class.">";
							echo $users[$info->$fieldName];
							echo "</td>";
						}
						elseif(preg_match('/^(createdDate|lastEditedDate)$/i', $fieldName))
						{
							echo "<td>";
							echo substr($info->$fieldName, 5, 11);
							echo "</td>";
						}
						elseif(preg_match('/^(pri|status)$/i', $fieldName))
						{
							echo "<td>";
							$key = $fieldName . 'List';
							$list = $lang->info->$key;
							echo $list[$info->$fieldName];
							echo "</td>";
						}
						else
						{
							echo "<td>";
							echo !($info->$fieldName == '0') ? $info->$fieldName : '';
							echo "</td>";
						}
						?>
					<?php endforeach;?>
					<td>
						<nobr>
							<?php
							$params = "infoID=$info->id";
							common::printLink('info', 'edit', $params, $lang->info->buttonEdit);
							common::printLink('info', 'delete', $params, $lang->delete, 'hiddenwin');
							?>
						</nobr>
					</td>
				</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot><tr><td colspan='<?php echo count($customFields)+1;?>'><?php $pager->show();?></td></tr></tfoot>
			</table>
		</td>
	</tr>
</table>
<?php include './footer.html.php';?>

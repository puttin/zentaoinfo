<?php include './header.html.php';?>
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
				echo "<span id='bymoduleTab' onclick=\"browseByModule('$browseType')\"><a href='#'>" . $lang->info->moduleInfos . "</a></span> ";
				echo "<span id='createdbymeTab'>". html::a($this->createLink('info', 'browse', "libID=$libID&moduleID=$moduleID&browseType=createdByMe&param=0"),$lang->info->createdByMe). "</span>";
				echo "<span id='postponedTab'>" . html::a($this->createLink('info', 'browse', "libID=$libID&moduleID=$moduleID&browseType=postponed&param=0"), $lang->info->postponed) . "</span>";
				echo "<span id='mailtomeTab'>" . html::a($this->createLink('info', 'browse', "libID=$libID&moduleID=$moduleID&browseType=mailtome&param=0"), $lang->info->mailtome) . "</span>";
			}
			echo "<span id='allTab'>". html::a($this->createLink('info', 'browse', "libID=$libID&moduleID=$moduleID&browseType=all"),$lang->info->allInfos). "</span>";
		?>
		<span id='bysearchTab'><a href='#'><span class='icon-search'></span><?php echo $lang->info->searchInfo;?></a></span>
	</div>
	<div class='f-right'>
	<?php common::printLink('info', 'export', "libID=$libID&orderBy="."Stickie_desc,"."$orderBy", $lang->export, '', 'class="export"'); ?>
	<?php common::printLink('info', 'customFields', '', $lang->info->customFields, '', "class='iframe'"); ?>
	<?php common::printLink('info', 'create', "libID=$libID&moduleID=$moduleID", $lang->info->create); ?>
	</div>
</div>
<div id='querybox' class='<?php if($browseType !='bysearch') echo 'hidden';?>'><?php echo $searchForm;?></div>
<?php if($customed){include 'browse.custom.html.php'; exit;}?>
<table class='cont-lt2'>
	<tr valign='top'>
		<td class='side <?php echo $treeClass;?>' id='treebox'>
			<div class='box-title'><?php echo $lang->info->module;?></div>
			<div class='box-content'>
			<?php echo $moduleTree;?>
			<div class='a-right'>
				<?php common::printLink('info', 'treemanage', "rootID=$libID", $lang->tree->manage);?>
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
						
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<th class='w-pri'>  <?php common::printOrderLink('pri', $orderBy, $vars, $lang->priAB);?></th>
						<?php endif;?>
						
						<th><?php common::printOrderLink('title', $orderBy, $vars, $lang->info->title);?></th>
			
						<th class='w-user'><?php common::printOrderLink('createdBy',$orderBy, $vars, $lang->openedByAB);?></th>
			
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<th class='w-date'>  <?php common::printOrderLink('createdDate', $orderBy, $vars, $lang->info->createdDateAB);?></th>
						<?php endif;?>
						
						<th class='w-user'><?php common::printOrderLink('lastEditedBy',$orderBy, $vars, $lang->info->lastEditedBy);?></th>
			
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<th class='w-date'>  <?php common::printOrderLink('lastEditedDate', $orderBy, $vars, $lang->info->lastEditedDate);?></th>
						<?php endif;?>
			
						<th class='w-70px {sorter:false}'><?php echo $lang->actions;?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($infos as $info):?>
				<?php $classcreatedby = $info->createdBy == $app->user->account ? 'style=color:red' : '';?>
				<?php $classlasteditedby = $info->lastEditedBy == $app->user->account ? 'style=color:red' : '';?>
					<?php $infoLink = inlink('view', "infoID=$info->id");?>
					<tr class='a-center'>
						<td class='linkbox '><?php echo html::a($infoLink, sprintf('%03d', $info->id));?></td>
						
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<td><?php echo $lang->info->priList[$info->pri]?></td>
						<?php endif;?>
						
						<?php
							$class = 'stickie' . $info->stickie;
							$highlight=$info->highlight;
							$title=$highlight ? '<a style="font-weight: bold;font-size: 110%;color: '.$highlight.';" href="'.$infoLink.'" >'.$info->title.'</a>' : html::a($infoLink, $info->title);
						?>
						<td class='a-left nobr'><?php echo "<span class='$class'>{$lang->info->StickieList[$info->stickie]} </span>" . $title;?></td>
						
						<td <?php echo $classcreatedby;?>><?php echo $users[$info->createdBy];?></td>
						
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<td><?php echo substr($info->createdDate, 5, 11);?></td>
						<?php endif;?>
						
						<td <?php echo $classlasteditedby;?>><?php echo $users[$info->lastEditedBy];?></td>
						
						<?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
						<td><?php echo substr($info->lastEditedDate, 5, 11);?></td>
						<?php endif;?>
						
						<td>
						<?php
						$params = "infoID=$info->id";
						common::printLink('info', 'edit', $params, $lang->info->buttonEdit);
						common::printLink('info', 'delete', $params, $lang->delete, 'hiddenwin');
						?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
				<tfoot>
					<tr>
						<?php $columns = $this->cookie->windowWidth > $this->config->wideSize ? 8 : 5;?>
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

<?php include './footer.html.php';?>

<?php include './header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<?php include '../../common/view/colorize.html.php';?>
<script language='Javascript'>
var browseType = '<?php echo $browseType;?>';
var moduleID   = '<?php echo $moduleID;?>';
</script>

<div id='featurebar'>
  <div class='f-left'>
	<?php if ($libID){
		echo "<span id='bymoduleTab' onclick=\"browseByModule('$browseType')\"><a href='#'>" . $lang->info->moduleInfos . "</a></span> ";
	}
	echo "<span id='allTab'>". html::a($this->createLink('info', 'browse', "libID=0&moduleID=0&browseType=all"),$lang->info->allInfos). "</span>";
	?>
  </div>
  <div class='f-right'>
	<?php common::printLink('info', 'create', "libID=$libID&moduleID=$moduleID", $lang->info->create); ?>
  </div>
</div>

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
		<td class='divider <?php echo $treeClass;?>'></td>
		<td>
		   <?php $vars = "libID=$libID&moduleID=$moduleID&browseType=$browseType&param=$param&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"; ?>
		  <table class='table-1 fixed colored tablesorter datatable'>
			<thead>
			<tr class='colhead'>
			  <th class='w-id'>       <?php common::printOrderLink('id',$orderBy, $vars, $lang->idAB);?></th>

			  <th><?php common::printOrderLink('title', $orderBy, $vars, $lang->info->title);?></th>
	
			  <th class='w-user'><?php common::printOrderLink('createdBy',$orderBy, $vars, $lang->openedByAB);?></th>
	
			  <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
			  <th class='w-date'>  <?php common::printOrderLink('createdDate', $orderBy, $vars, $lang->info->createdDateAB);?></th>
			  <?php endif;?>
			  <th class='w-user'><?php common::printOrderLink('lastEditedBy',$orderBy, $vars, $lang->info->lastEditedBy);?></th>
	
			  <?php if($this->cookie->windowWidth >= $this->config->wideSize):?>
			  <th class='w-date'>  <?php common::printOrderLink('lastEditedDate', $orderBy, $vars, $lang->info->lastEditedDate);?></th>
			  <?php endif;?>
	
			  <th class='w-140px {sorter:false}'><?php echo $lang->actions;?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($infos as $info):?>
				<?php $infoLink = inlink('view', "infoID=$info->id");?>
				<tr class='a-center'>
					<td class='linkbox <?php echo $class;?>'><?php echo html::a($infoLink, sprintf('%03d', $info->id));?></td>
					<td class='a-left nobr'><?php echo html::a($infoLink, $info->title);?></td>
					<td><?php echo $users[$info->createdBy];?></td>
					<td><?php echo substr($info->createdDate, 5, 11)?></td>
					<td><?php echo $users[$info->lastEditedBy];?></td>
					<td><?php echo substr($info->lastEditedDate, 5, 11)?></td>
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
			<tfoot><tr><td colspan='7'><?php $pager->show();?></td></tr></tfoot>
		  </table>
		</td>
	</tr>
</table> 

<?php include './footer.html.php';?>

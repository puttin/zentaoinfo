<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/tablesorter.html.php';?>
<table class='table-1 tablesorter fixed'>
  <caption class='caption-tl'>
    <div class='f-left'><?php echo $lang->custom->{$type.'Custom'};?></div>
    <div class='f-right'><?php common::printLink('custom', 'create', "moduleType=$type", $lang->custom->create,"_self","class='edit-custom' title='".$lang->custom->create."'");?></div>
  </caption>
  <thead>
  <tr class='colhead'>
    <th class='w-120px'><?php echo $lang->custom->Field;?></th>
    <th class='text-4'><?php echo $lang->custom->Type;?></th>
    <th class='w-120px'><?php echo $lang->custom->Default;?></th>
    <th class='w-30px'><?php echo $lang->custom->Null;?></th>
    <th><?php echo $lang->custom->Comment;?></th>
    <th class='w-140px'><?php echo $lang->actions;?></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach($customs as $custom):?>
  <tr class='a-center'>
    <td><?php echo $custom->Field;?></td>
    <td><?php echo $custom->Type;?></td>
    <td><?php echo $custom->Default;?></td>
    <td><?php echo $lang->custom->{$custom->Null};?></td>
    <td><?php echo $custom->Comment;?></td>
    <td>
      <?php 
      common::printLink('custom', 'edit',   "moduleType=$type&field=$custom->Field", $lang->edit,'_self',"class='edit-custom' title='".$lang->custom->edit."'");
      common::printLink('custom', 'delete', "moduleType=$type&field=$custom->Field", $lang->delete, 'hiddenwin');
      ?>
    </td>
  </tr>
  <?php endforeach;?>
  </tbody>
</table>
<?php include '../../common/view/footer.html.php';?>

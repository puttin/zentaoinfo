<?php include './header.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
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

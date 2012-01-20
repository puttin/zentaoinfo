<?php include '../../common/view/header.lite.html.php';?>
<form method='post'>
  <table class='table-1'> 
    <caption><?php echo $lang->info->editLib;?></caption>
    <tr>
      <th class='rowhead'><?php echo $lang->info->libName;?></th>
      <td><?php echo html::input('name', $libName, "class='text-1'");?></td>
    </tr>
    <tr>
      <th class='rowhead'><?php echo $lang->info->libDefault;?></th>
      <td><input type='checkbox' name='defaultlib' <?php if(isset($defaultLib) and $defaultLib==$libID) echo "checked";?> /></td>
    </tr>
    <tr><td colspan='2' class='a-center'><?php echo html::submitButton();?></td></tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>

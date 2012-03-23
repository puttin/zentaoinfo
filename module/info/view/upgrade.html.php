<?php include '../../common/view/header.lite.html.php';?>
<form method='post' action='<?php echo inlink('execute');?>'>
  <table align='center' class='table-5 f-14px'>
    <caption><?php echo $lang->info->upgradeSelectVersion;?></caption>
    <tr>
      <th class='w-p20 rowhead'><?php echo $lang->info->upgradeFromVersion;?></th>
      <td><?php echo html::select('fromVersion', $lang->info->upgradeFromVersions) . "<span class='red'>{$lang->info->upgradeNoteVersion}</span>";?></td>
    </tr>
    <tr>
      <th class='w-p20 rowhead'><?php echo $lang->info->upgradeToVersion;?></th>
      <td><?php echo $oldInfo;?></td>
    </tr>
    <tr>
      <td colspan='2' class='a-center'><?php echo html::submitButton($lang->info->upgradeCommon);?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.lite.html.php';?>

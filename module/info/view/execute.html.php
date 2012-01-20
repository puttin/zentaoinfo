<?php include '../../common/view/header.lite.html.php';?>
<?php
	$tmp = 'upgrade'.$result;
?>
<table align='center' class='table-5 f-14px'>
  <caption><?php echo $lang->info->$tmp;?></caption>
  <tr>
    <td>
    <?php
    if($result == 'Fail')
    {
        echo nl2br(join('\n', $errors));
    }
    else
    {
        echo js::refresh('info');
        echo html::linkButton($lang->info->upgradeTohome, 'info');
    }
    ?>
    </td>
  </tr>
</table>
<?php include '../../common/view/footer.lite.html.php';?>

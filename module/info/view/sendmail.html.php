<h1 class="caption"><?php echo $lang->info->mailModify ?></h1>
<table width='98%' align='center'>
  <tr class='header'>
    <td>
      INFO #<?php echo $info->id . html::a(common::getSysURL() . $this->createLink('info', 'view', "infoID=$info->id"), $info->title);?>
    </td>
  </tr>
  <tr>
    <td><?php include '../../common/view/mail.html.php';?></td>
  </tr>
</table>
<h1 class="caption"><?php echo $lang->info->mailMain ?></h1>
<table width='98%' align='center'>
  <tr>
    <td class="content"><?php echo $info->content;?></td>
  </tr>
</table>
<style>
	.caption {font-weight:bold; font-size:150%;}
	.content {line-height:80%;}
</style>
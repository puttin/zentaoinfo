<script language='Javascript'>
$(document).ready(function()
{
    $(".right a").colorbox({width:500, height:200, iframe:true, transition:'none'});  // The create lib link.
    $("#modulemenu a:contains('<?php echo $lang->info->editLib;?>')").colorbox({width:500, height:200, iframe:true, transition:'none'});   // The edit lib link.
    $("#modulemenu a:contains('<?php echo $lang->info->upgradeCommon;?>')").colorbox({width:700, height:300, iframe:true, transition:'none'});   // The edit lib link.
    $("#modulemenu a:contains('<?php echo $lang->asset->editLib;?>')").colorbox({width:500, height:200, iframe:true, transition:'none'});   // The asset edit lib link.
});
</script>
<?php include '../../common/view/footer.html.php';?>


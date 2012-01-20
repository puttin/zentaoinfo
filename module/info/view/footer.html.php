<script language='Javascript'>
$(document).ready(function()
{
    $(".right a").colorbox({width:500, height:200, iframe:true, transition:'none'});  // The create lib link.
    $("a.iframe").colorbox({width:480, height:240, iframe:true, transition:'none'});
    $("#modulemenu a:contains('<?php echo $lang->info->editLib;?>')").colorbox({width:500, height:200, iframe:true, transition:'none'});   // The edit lib link.
});
</script>
<?php include '../../common/view/footer.html.php';?>


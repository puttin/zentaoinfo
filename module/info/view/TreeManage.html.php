<?php include '../../common/view/header.html.php';?>
<?php include '../../common/view/treeview.html.php';?>
<table class='cont-lt5'>
  <tr valign='top'>
    <td class='side'>
      <form method='post' target='hiddenwin' action='<?php echo $this->createLink('info', 'updateOrder', "root={$root->id}&viewType=$viewType");?>'>
        <table class='table-1'>
          <caption><?php echo $header->title;?></caption>
          <tr>
            <td>
              <div id='main'><?php echo $modules;?></div>
              <div class='a-center'>
                <?php if(common::hasPriv('info', 'TreeUpdateOrder')) echo html::submitButton($lang->tree->updateOrder);?>
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
    <td class='divider'></td>
    <td>
      <form method='post' target='hiddenwin' action='<?php echo $this->createLink('info', 'manageChild', "root={$root->id}");?>'>
        <table align='center' class='table-1'>
          <caption><?php echo $lang->tree->manageChild;?></caption>
          <tr>
            <td width='10%'>
              <nobr>
              <?php
              echo html::a($this->createLink('info', 'TreeManage', "root={$root->id}"), $root->name);
              echo $lang->arrow;
              foreach($parentModules as $module)
              {
                  echo html::a($this->createLink('info', 'TreeManage', "root={$root->id}&moduleID=$module->id"), $module->name);
                  echo $lang->arrow;
              }
              ?>
              </nobr>
            </td>
            <td id='moduleBox'> 
              <?php
              $maxOrder = 0;
              echo '<div id="sonModule">';
              foreach($sons as $sonModule)
              {
                  if($sonModule->order > $maxOrder) $maxOrder = $sonModule->order;
                  echo '<span>' . html::input("modules[id$sonModule->id]", $sonModule->name, 'class=text-3 style="margin-bottom:5px"') . '<br /></span>';
              }
              for($i = 0; $i < INFO::NEW_CHILD_COUNT ; $i ++) echo '<span>' . html::input("modules[]", '', 'class=text-3 style="margin-bottom:5px"') . '<br /></span>';
              ?>
              </div>
            </td>
          </tr>
          <tr>
            <td class='a-center' colspan='3'>
              <?php 
              echo html::submitButton() . html::resetButton();
              echo html::hidden('parentModuleID', $currentModuleID);
              echo html::hidden('maxOrder', $maxOrder);
              ?>      
              <input type='hidden' value='<?php echo $currentModuleID;?>' name='parentModuleID' />
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
<?php include './footer.html.php';?>

<?php
$lang->menugroup->asset        = 'info';
$lang->searchObjects['asset']         = 'A:資產';

/* 资产视图菜单设置。*/
$lang->asset->menu->list    = '%s';
$lang->asset->menu->browse  = array('link' => '資產列表|asset|browse|libID=%s','alias' => 'view,create,edit');
$lang->asset->menu->edit    = '編輯資產庫|asset|editLib|libID=%s&type=asset';
$lang->asset->menu->delete  = array('link' => '刪除資產庫|asset|deleteLib|libID=%s&type=asset', 'target' => 'hiddenwin');
$lang->asset->menu->module  = array('link' => '維護模塊|info|TreeManage|libID=%s&module=0&type=asset','alias' => 'treemanage');
$lang->asset->menu->info  = '公告列表|info|browse|';
$lang->asset->menu->create  = array('link' => '<span class="icon-add1">&nbsp;</span>新增資產庫|asset|createLib|type=asset', 'float' => 'right');

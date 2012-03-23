<?php
$lang->menugroup->asset        = 'info';
$lang->searchObjects['asset']         = 'Asset';

/* 资产视图菜单设置。*/
$lang->asset->menu->list    = '%s';
$lang->asset->menu->browse  = array('link' => 'Asset List|asset|browse|libID=%s','alias' => 'view,create,edit');
$lang->asset->menu->edit    = 'Edit Asset Library|asset|editLib|libID=%s&type=asset';
$lang->asset->menu->delete  = array('link' => 'Delete Asset Library|asset|deleteLib|libID=%s&type=asset', 'target' => 'hiddenwin');
$lang->asset->menu->module  = array('link' => 'Module|info|TreeManage|libID=%s&module=0&type=asset','alias' => 'treemanage');
$lang->asset->menu->info  = 'Info|info|browse|';
$lang->asset->menu->create  = array('link' => '<span class="icon-add1">&nbsp;</span>New Asset Library|asset|createLib|&type=asset', 'float' => 'right');

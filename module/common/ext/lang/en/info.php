<?php
/* 主导航菜单。*/
$lang->menu->info      = 'Info|info|index';
$lang->searchObjects['info']         = 'Info';

/* 公告视图菜单设置。*/
$lang->info->menu->list    = '%s';
$lang->info->menu->browse  = array('link' => 'Info|info|browse|libID=%s','alias' => 'view,create,edit');
$lang->info->menu->edit    = 'Edit Library|info|editLib|libID=%s';
$lang->info->menu->delete  = array('link' => 'Delete Library|info|deleteLib|libID=%s', 'target' => 'hiddenwin');
$lang->info->menu->module  = array('link' => 'Module|info|TreeManage|libID=%s','alias' => 'treemanage');
$lang->info->menu->asset  = 'Asset|asset|browse|';
$lang->info->menu->upgrade  = 'Upgrade Plugin|info|upgrade|';
$lang->info->menu->create  = array('link' => 'New Library|info|createLib', 'float' => 'right');

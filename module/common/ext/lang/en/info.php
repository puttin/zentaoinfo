<?php
/* 主导航菜单。*/
$lang->menu->info      = 'Info|info|index';
$lang->searchObjects['info']         = 'Info';

/* 公告视图菜单设置。*/
$lang->info->menu->list    = '%s';
$lang->info->menu->browse  = array('link' => 'Info|info|browse|libID=%s');
$lang->info->menu->edit    = 'Edit Library|info|editLib|libID=%s';
$lang->info->menu->delete  = array('link' => 'Delete Library|info|deleteLib|libID=%s', 'target' => 'hiddenwin');
$lang->info->menu->module  = 'Modules|info|treemanage|libID=%s';
//$lang->info->menu->machine  = '机器信息|machine|browse|libID=%s&viewType=doc';
$lang->info->menu->create  = array('link' => 'New Library|info|createLib', 'float' => 'right');

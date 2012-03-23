<?php
$lang->menugroup->asset        = 'info';
$lang->searchObjects['asset']         = 'A:资产';

/* 资产视图菜单设置。*/
$lang->asset->menu->list    = '%s';
$lang->asset->menu->browse  = array('link' => '资产列表|asset|browse|libID=%s','alias' => 'view,create,edit');
$lang->asset->menu->edit    = '编辑资产库|info|editLib|libID=%s&type=asset';
$lang->asset->menu->delete  = array('link' => '删除资产库|info|deleteLib|libID=%s&type=asset', 'target' => 'hiddenwin');
$lang->asset->menu->module  = array('link' => '维护模块|info|TreeManage|libID=%s&module=0&type=asset','alias' => 'treemanage');
$lang->asset->menu->info  = '公告列表|info|browse|';
$lang->asset->menu->create  = array('link' => '<span class="icon-add1">&nbsp;</span>新增资产库|info|createLib|type=asset', 'float' => 'right');

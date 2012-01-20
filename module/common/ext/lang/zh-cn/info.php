<?php
/* 主导航菜单。*/
$lang->menu->info      = '信息公告|info|index';
$lang->searchObjects['info']         = 'I:公告';

/* 公告视图菜单设置。*/
$lang->info->menu->list    = '%s';
$lang->info->menu->browse  = array('link' => '公告列表|info|browse|libID=%s','alias' => 'view,create,edit');
$lang->info->menu->edit    = '编辑公告库|info|editLib|libID=%s';
$lang->info->menu->delete  = array('link' => '删除公告库|info|deleteLib|libID=%s', 'target' => 'hiddenwin');
$lang->info->menu->module  = array('link' => '维护模块|info|TreeManage|libID=%s','alias' => 'treemanage');
$lang->info->menu->asset  = '资产列表|asset|browse|';
$lang->info->menu->upgrade  = '升级插件|info|upgrade|';
$lang->info->menu->create  = array('link' => '新增公告库|info|createLib', 'float' => 'right');

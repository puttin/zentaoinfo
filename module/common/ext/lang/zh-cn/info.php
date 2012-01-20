<?php
/* 主导航菜单。*/
$lang->menu->info      = '信息公告|info|index';
$lang->searchObjects['info']         = 'I:公告';

/* 公告视图菜单设置。*/
$lang->info->menu->list    = '%s';
$lang->info->menu->browse  = array('link' => '公告列表|info|browse|libID=%s');
$lang->info->menu->edit    = '编辑公告库|info|editLib|libID=%s';
$lang->info->menu->delete  = array('link' => '删除公告库|info|deleteLib|libID=%s', 'target' => 'hiddenwin');
$lang->info->menu->module  = '维护模块|info|treemanage|libID=%s';
//$lang->info->menu->machine  = '机器信息|machine|browse|libID=%s&viewType=doc';
$lang->info->menu->upgrade  = '升级插件|info|upgrade|';
$lang->info->menu->create  = array('link' => '新增公告库|info|createLib', 'float' => 'right');

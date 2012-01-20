<?php
/* 主导航菜单。*/
$lang->menu->info      = '信息公告|info|index';
$lang->searchObjects['info']         = 'I:公告';

/* 公告视图菜单设置。*/
$lang->info->menu->list    = '%s';
$lang->info->menu->browse  = array('link' => '公告列表|info|browse|libID=%s');
$lang->info->menu->edit    = '編輯公告庫|info|editLib|libID=%s';
$lang->info->menu->delete  = array('link' => '刪除公告庫|info|deleteLib|libID=%s', 'target' => 'hiddenwin');
$lang->info->menu->module  = '維護模塊|info|treemanage|libID=%s';
//$lang->info->menu->machine  = '机器信息|machine|browse|libID=%s&viewType=doc';
$lang->info->menu->create  = array('link' => '新增公告庫|info|createLib', 'float' => 'right');

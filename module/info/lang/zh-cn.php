<?php
/**
 * The install module zh-cn file of ZenTaoPMS.
 *
 * @author		Yanzhi Wang
 * @package		info
 */
$lang->info->common				= '信息公告';
$lang->info->list				= '公告列表';
$lang->info->module				= '模块';
$lang->info->welcome				= '感谢您选择使用信息公告插件! ';
$lang->info->gotoInfoIndex		= '您是否需要前往信息公告首页?';

/* 方法列表。*/
$lang->info->index				= '公告首页';
$lang->info->create				= '创建公告';
$lang->info->export				= '导出数据';
$lang->info->edit				= '编辑公告';
$lang->info->browse				= '公告列表';
$lang->info->view				= '公告详情';
$lang->info->delete				= '删除公告';
$lang->info->createLib      = '创建公告库';
$lang->info->editLib        = '编辑公告库';
$lang->info->deleteLib      = '删除公告库';
$lang->info->TreeManage			= '公告模块维护';
$lang->info->TreeUpdateOrder	= '公告模块更新排序';
$lang->info->TreeManageChild	= '维护子公告模块';
$lang->info->TreeEdit			= '公告模块编辑';
$lang->info->TreeDelete			= '公告模块删除';
$lang->info->HighlightAndStickie = '置顶与高亮';
$lang->info->TreeAjaxGetOptionMenu = '接口:获取下拉列表';
$lang->info->TreeAjaxGetSonModules = '接口:获得子菜单列表';

/* 查询条件列表。*/
$lang->info->moduleInfos			= '按模块浏览';
$lang->info->allInfos			= '全部公告';
$lang->info->createdByMe			= '由我创建';
$lang->info->postponed			= '已过期';
$lang->info->mailtome			= '抄送给我';

/* 字段列表。*/
$lang->info->id             = '公告编号';
$lang->info->libName        = '公告库名称';
$lang->info->libDefault        = '默认公告库';
$lang->info->title				= '公告标题';
$lang->info->createdBy         = '由谁创建';
$lang->info->createdDate		= '创建日期';
$lang->info->createdDateAB		= '创建日期';
$lang->info->lastEditedBy		= '最后修改';
$lang->info->lastEditedDate		= '修改日期';
$lang->info->lib         = '所属库';
$lang->info->module         = '所属分类';
$lang->info->content        = '公告正文';
$lang->info->keywords       = '关键字';
$lang->info->files          = '附件';
$lang->info->digest         = '公告摘要';
$lang->info->legendBasicInfo   = '基本信息';
$lang->info->legendLife        = '公告的一生';
$lang->info->editedCount       = '修改次数';
$lang->info->comment           = '备注';
$lang->info->deadline           = '过期日期';
$lang->info->Stickie           = '置顶';
$lang->info->Highlight           = '高亮';
$lang->info->highlightLabel           = '高亮效果';
$lang->info->highlightTryMe           = '&nbsp;←点击试试看!';
$lang->info->pri              = '优先级';
$lang->info->searchInfo = '搜索';
$lang->info->stickie              = '置顶';
$lang->info->highlight              = '高亮';

/* 功能按钮。*/
$lang->info->buttonEdit			= '编辑';
$lang->info->buttonCopy			= '拷贝';

/* 交互提示。*/
$lang->info->confirmDelete      = "您确定删除该公告吗？";
$lang->info->confirmDeleteLib   = " 您确定删除该公告库吗？";
$lang->info->noLib   = " 不存在公告库,请先建立公告库";
$lang->info->pleaseUpgrade = '请联系管理员升级插件!';

$lang->info->manageCustom   = '维护公告库模块';
$lang->info->confirmChangeLib   = '修改公告库会导致相应的分类发生变化，确定吗？';
$lang->info->confirmUninstallPlugin   = '卸载禅道信息公告插件会删除所有该插件的动态信息,造成之后再使用时,所有公告历史记录消失!您确认卸载该插件吗?';
$lang->info->pleaseGoToDeletePreuninstall ='请前往 "%s" 目录删除 preuninstall.php 文件后再重新卸载.';

/* 插件升级。*/
$lang->info->upgradeCommon  = '升级插件';
$lang->info->upgradeResult  = '升级结果';
$lang->info->upgradeFail    = '升级失败';
$lang->info->upgradeSuccess = '升级成功';
$lang->info->upgradeTohome  = '返回公告首页';
$lang->info->upgradeSelectVersion = '选择插件版本';
$lang->info->upgradeNoteVersion   = "务必选择正确的插件版本，否则会造成数据丢失。";
$lang->info->upgradeFromVersion   = '原来的插件版本';
$lang->info->upgradeToVersion     = '升级到';

$lang->info->upgradeFromVersions['0_1']   = '0.1 或 0.1.1';
$lang->info->upgradeFromVersions['0_2']   = '0.2';

/* 邮件抄送。*/
$lang->info->mailModify ='此次变化';
$lang->info->mailMain ='当前内容';
$lang->info->mailto           = '抄送给';
$lang->info->lblMailto                   = '抄送给';

$lang->info->delayWarning        = " <strong class='delayed f-14px'> 过期%s天 </strong>";

/* 各个字段取值列表。*/
$lang->info->StickieList[0] = '';
$lang->info->StickieList[1] = '[置顶]';
$lang->info->StickieList[2] = '[总置顶]';

$lang->info->StickieLable[0] = '普通';
$lang->info->StickieLable[1] = '置顶';
$lang->info->StickieLable[2] = '总置顶';

$lang->info->priList[0] = '';
$lang->info->priList[1] = '1';
$lang->info->priList[2] = '2';
$lang->info->priList[3] = '3';
$lang->info->priList[4] = '4';

/* 自定义字段 */
$lang->info->customFields   = '自定义字段';
$lang->info->restoreDefault = '恢复默认';
$lang->info->lblAllFields                = '所有字段';
$lang->info->lblCustomFields             = '自定义字段';
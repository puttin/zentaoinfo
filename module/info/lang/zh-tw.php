<?php
/**
 * The install module zh-cn	file of	ZenTaoPMS.
 *
 * @author		Yanzhi Wang
 * @package		info
 */
$lang->info->common				= '信息公告';
$lang->info->list				= '公告列表';
$lang->info->module				= '模塊';
$lang->info->welcome				= '感謝您選擇使用信息公告插件! ';
$lang->info->gotoInfoIndex		= '您是否需要前往信息公告首頁?';

/* 方法列表。*/
$lang->info->index				= '公告首頁';
$lang->info->create				= '創建公告';
$lang->info->export				= '導出數據';
$lang->info->edit				= '編輯公告';
$lang->info->browse				= '公告列表';
$lang->info->view				= '公告詳情';
$lang->info->delete				= '刪除公告';
$lang->info->createLib      = '創建公告庫';
$lang->info->editLib        = '編輯公告庫';
$lang->info->deleteLib      = '刪除公告庫';
$lang->info->TreeManage			= '公告模塊維護';
$lang->info->TreeUpdateOrder	= '公告模塊更新排序';
$lang->info->TreeManageChild	= '維護子模塊';
$lang->info->TreeEdit			= '公告模塊編輯';
$lang->info->TreeDelete			= '公告模塊刪除';
$lang->info->HighlightAndStickie = '置頂與高亮';
$lang->info->TreeAjaxGetOptionMenu = '接口:獲取下拉列表';
$lang->info->TreeAjaxGetSonModules = '接口:獲得子菜單列表';

/* 查询条件列表。*/
$lang->info->moduleInfos			= '按模塊瀏覽';
$lang->info->allInfos			= '全部公告';
$lang->info->createdByMe			= '由我創建';
$lang->info->postponed			= '已過期';
$lang->info->mailtome			= '抄送給我';

/* 字段列表。*/
$lang->info->id             = '公告編號';
$lang->info->libName        = '公告庫名稱';
$lang->info->libDefault        = '默認公告庫';
$lang->info->title				= '公告標題';
$lang->info->createdBy         = '有誰創建';
$lang->info->createdDate		= '創建日期';
$lang->info->createdDateAB		= '創建日期';
$lang->info->lastEditedBy		= '最後修改';
$lang->info->lastEditedDate		= '修改日期';
$lang->info->lib         = '所屬庫';
$lang->info->module         = '所屬分類';
$lang->info->content        = '公告正文';
$lang->info->keywords       = '關鍵字';
$lang->info->files          = '附件';
$lang->info->digest         = '公告摘要';
$lang->info->legendBasicInfo   = '基本信息';
$lang->info->legendLife        = '公告的一生';
$lang->info->legendCustomInfo		= '自定義信息';
$lang->info->editedCount       = '修改次數';
$lang->info->viewedCount       = '查看次數';
$lang->info->comment           = '備註';
$lang->info->deadline           = '過期日期';
$lang->info->Stickie           = '置頂';
$lang->info->Highlight           = '高亮';
$lang->info->highlightLabel           = '高亮效果';
$lang->info->highlightTryMe           = '&nbsp;←點擊試試看!';
$lang->info->pri              = '優先級';
$lang->info->searchInfo = '搜索';
$lang->info->stickie              = '置頂';
$lang->info->highlight              = '高亮';
$lang->info->relatedBug            = '相關Bug';
$lang->info->relatedStory            = '相關需求';
$lang->info->relatedTask            = '相關任務';

/* 功能按鈕。*/
$lang->info->buttonEdit			= '編輯';
$lang->info->buttonCopy			= '拷貝';

/* 交互提示。*/
$lang->info->confirmDelete      = "您確定刪除該公告嗎？";
$lang->info->confirmDeleteLib   = " 您確定刪除該公告庫嗎？";
$lang->info->noLib   = " 不存在公告庫,請先建立一個公告庫!";
$lang->info->pleaseUpgrade = '請聯繫管理員升級插件!';

$lang->info->manageCustom   = '維護公告庫模塊';
$lang->info->confirmChangeLib   = '修改公告庫會導致相應的分類變化，確定嗎？';
$lang->info->confirmUninstallPlugin   = '卸載禪道信息公告插件會刪除所有該插件的動態信息,造成之後再次使用時,所有公告歷史記錄消失!您確認卸載嗎?';
$lang->info->pleaseGoToDeletePreuninstall ='請前往 "%s" 目錄刪除 preuninstall.php 文件後再重新卸載.';

/* 插件升級。*/
$lang->info->upgradeCommon  = '升級插件';
$lang->info->upgradeResult  = '升級結果';
$lang->info->upgradeFail    = '升級失敗';
$lang->info->upgradeSuccess = '升級成功';
$lang->info->upgradeTohome  = '返回公告首頁';
$lang->info->upgradeSelectVersion = '選擇插件版本';
$lang->info->upgradeNoteVersion   = "務必選擇正確的插件版本，否則會造成數據丟失。";
$lang->info->upgradeFromVersion   = '原來的插件版本';
$lang->info->upgradeToVersion     = '升級到';

$lang->info->upgradeFromVersions['0_1']   = '0.1 或 0.1.1';
$lang->info->upgradeFromVersions['0_2']   = '0.2';
$lang->info->upgradeFromVersions['0_3']   = '0.3';

/* 郵件抄送。*/
$lang->info->mailModify ='此次變化';
$lang->info->mailMain ='當前內容';
$lang->info->mailto           = '抄送給';
$lang->info->lblMailto                   = '抄送給';

$lang->info->delayWarning        = " <strong class='delayed f-14px'> 過期%s天 </strong>";

/* 各個字段取值列表。*/
$lang->info->StickieList[0] = '';
$lang->info->StickieList[1] = '[置頂]';
$lang->info->StickieList[2] = '[總置頂]';

$lang->info->StickieLable[0] = '普通';
$lang->info->StickieLable[1] = '置頂';
$lang->info->StickieLable[2] = '總置頂';

$lang->info->priList[0] = '';
$lang->info->priList[1] = '1';
$lang->info->priList[2] = '2';
$lang->info->priList[3] = '3';
$lang->info->priList[4] = '4';

/* 自定義字段 */
$lang->info->customFields   = '自定義顯示';
$lang->info->restoreDefault = '恢復默認';
$lang->info->lblAllFields                = '所有字段';
$lang->info->lblCustomFields             = '自定義顯示';
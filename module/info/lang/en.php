<?php
/**
 * The install module zh-cn	file of	ZenTaoPMS.
 *
 * @author		Yanzhi Wang
 * @package		info
 */
$lang->info->common				= 'INFO';
$lang->info->list				= 'Info List';
$lang->info->module				= 'MODULE';
$lang->info->welcome				= 'Thanks for using Info plugin! ';
$lang->info->gotoInfoIndex		= 'Do you want to locate to Info Index?';

/* 方法列表。*/
$lang->info->index				= 'Info Index';
$lang->info->create				= 'Create Info';
$lang->info->export				= 'Export Data';
$lang->info->edit				= 'Edit Info';
$lang->info->browse				= 'Browse Info';
$lang->info->view				= 'View Info';
$lang->info->delete				= 'Delete Info';
$lang->info->createLib      = 'Create Info Lib';
$lang->info->editLib        = 'Edit Info Lib';
$lang->info->deleteLib      = 'Delete Info Lib';
$lang->info->TreeManage			= 'Info Module Manage';
$lang->info->TreeUpdateOrder	= 'Info Module Update Order';
$lang->info->TreeManageChild	= 'Info Module Manage Child';
$lang->info->TreeEdit			= 'Info Module Edit';
$lang->info->TreeDelete			= 'Info Module Delete';
$lang->info->HighlightAndStickie = 'Highlight And Stickie';
$lang->info->TreeAjaxGetOptionMenu = 'API: Get select menu';
$lang->info->TreeAjaxGetSonModules = 'API: Get son modules';

/* 查询条件列表。*/
$lang->info->moduleInfos			= 'ByModule';
$lang->info->allInfos			= 'AllInfo';
$lang->info->createdByMe			= 'CreatedByMe';
$lang->info->postponed			= 'Postponed';
$lang->info->mailtome			= 'MailedToMe';

/* 字段列表。*/
$lang->info->id             = 'Info Id';
$lang->info->libName        = 'Info Lib Name';
$lang->info->libDefault        = 'Default Lib';
$lang->info->title				= 'Title';
$lang->info->createdDate		= 'Created Date';
$lang->info->createdDateAB		= 'Created Date';
$lang->info->createdBy         = 'Created By';
$lang->info->lastEditedBy		= 'Last Edited By';
$lang->info->lastEditedDate		= 'Last Edited Date';
$lang->info->lib         = 'Library';
$lang->info->module         = 'Module';
$lang->info->content        = 'Content';
$lang->info->keywords       = 'Keywords';
$lang->info->files          = 'File';
$lang->info->digest         = 'Digest';
$lang->info->legendBasicInfo   = 'Basic Info';
$lang->info->legendLife        = 'Lifetime';
$lang->info->editedCount       = 'Edit Times';
$lang->info->comment           = 'Comment';
$lang->info->deadline           = 'Deadline';
$lang->info->Stickie           = 'Stickie';
$lang->info->Highlight           = 'Highlight';
$lang->info->highlightLabel           = 'Highlight Effect';
$lang->info->highlightTryMe           = '&nbsp;←Try Click!';
$lang->info->pri              = 'Priority';
$lang->info->searchInfo = 'Search';
$lang->info->stickie              = 'Stickie';
$lang->info->highlight              = 'Highlight';

/* button。*/
$lang->info->buttonEdit			= 'Edit';
$lang->info->buttonCopy			= 'Copy';

/* prompt。*/
$lang->info->confirmDelete      = "Are you sure to delete this info?";
$lang->info->confirmDeleteLib   = " Are you sure to delete this info library?";
$lang->info->noLib   = " No existed library,please create a info library first!";
$lang->info->pleaseUpgrade = 'Please contact Admin to upgrade this plugin!';

$lang->info->manageCustom   = 'Manage Info Module';
$lang->info->confirmChangeLib = 'Change library will change module also, are you sure?';
$lang->info->confirmUninstallPlugin   = "Uninstall this plugin will delete all action from TABLE_ACTION so that all infos' history will be LOST! Are you sure you wanna this?";
$lang->info->pleaseGoToDeletePreuninstall ='Please go to "%s" dir and delete preuninstall.php file before you restart uninstall this plugin.';

/* plugin update*/
$lang->info->upgradeCommon  = 'Upgrade Plugin';
$lang->info->upgradeResult  = 'Upgrade Result';
$lang->info->upgradeFail    = 'Upgrade Fail';
$lang->info->upgradeSuccess = 'Upgrade Success';
$lang->info->upgradeTohome  = 'Back to Info Index';
$lang->info->upgradeSelectVersion = 'Select plugin version';
$lang->info->upgradeNoteVersion   = "Please choose the right plugin version or maybe lost your data!";
$lang->info->upgradeFromVersion   = 'From version';
$lang->info->upgradeToVersion     = 'To version';

$lang->info->upgradeFromVersions['0_1']   = '0.1 or 0.1.1';
$lang->info->upgradeFromVersions['0_2']   = '0.2';

/* mail to*/
$lang->info->mailModify ='Modify';
$lang->info->mailMain ='Content';
$lang->info->mailto           = 'Mail To';
$lang->info->lblMailto                   = 'Mail To';

$lang->info->delayWarning        = " <strong class='delayed f-14px'> Postponed %s days </strong>";

/* list*/
$lang->info->StickieList[0] = '';
$lang->info->StickieList[1] = '[Top]';
$lang->info->StickieList[2] = '[Stickie]';

$lang->info->StickieLable[0] = 'Normal';
$lang->info->StickieLable[1] = 'Top';
$lang->info->StickieLable[2] = 'Stickie';

$lang->info->priList[0] = '';
$lang->info->priList[1] = '1';
$lang->info->priList[2] = '2';
$lang->info->priList[3] = '3';
$lang->info->priList[4] = '4';

/* custom */
$lang->info->customFields   = 'Custom';
$lang->info->restoreDefault = 'Default';
$lang->info->lblAllFields                = 'All Fields';
$lang->info->lblCustomFields             = 'Custom Fields';
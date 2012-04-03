<?php
$lang->custom->common				= '自定義字段';

/* 方法列表 */
$lang->custom->index				= '首頁';
$lang->custom->create				= '創建新字段';
$lang->custom->edit					= '編輯字段';
$lang->custom->delete				= '刪除字段';

/* 字段列表 */
$lang->custom->Field				= '名字';
$lang->custom->Type					= '類型';
$lang->custom->Length				= '長度/值';
$lang->custom->Default				= '默認';
$lang->custom->Null					= '空';
$lang->custom->Comment				= '註釋';

/* 功能按钮 */

/* 交互提示 */
$lang->custom->confirmDelete    	= "您確定刪除該字段嗎?";

/* 模块提示 */
$lang->custom->infoCustom			='自定義公告字段';
$lang->custom->assetCustom			='自定義資產字段';
$lang->custom->YES					='是';
$lang->custom->NO					='否';

$lang->custom->fieldEmpty			= 'Error!Field Cannot be empty!';
$lang->custom->alterTableFailed		= "Alter Table Failed.Please check the form you submitted.Or contact the author.";

/* list */
$lang->custom->DefaultList['NONE']			= 'None';
$lang->custom->DefaultList['USER_DEFINED']	= 'As defined:';
$lang->custom->DefaultList['NULL']			= 'Null';

//SPATIAL is not supported.
$lang->custom->TypeList['NUMERIC']		= array(
												'TINYINT'=>'TINYINT',
												'SMALLINT'=>'SMALLINT',
												'MEDIUMINT'=>'MEDIUMINT',
												'INT'=>'INT',
												'BIGINT'=>'BIGINT',
												'DECIMAL'=>'DECIMAL',
												'FLOAT'=>'FLOAT',
												'DOUBLE'=>'DOUBLE',
												'REAL'=>'REAL',
												'BIT'=>'BIT',
												'BOOLEAN'=>'BOOLEAN',
												'SERIAL'=>'SERIAL'
												);
$lang->custom->TypeList['DATE and TIME']= array(
												'DATE'=>'DATE',
												'DATETIME'=>'DATETIME',
												'TIME'=>'TIME',
												'YEAR'=>'YEAR'
												);//TIMESTAMP is not supported now
$lang->custom->TypeList['STRING']		= array(
												'CHAR'=>'CHAR',
												'VARCHAR'=>'VARCHAR',
												'TINYTEXT'=>'TINYTEXT',
												'TEXT'=>'TEXT',
												'MEDIUMTEXT'=>'MEDIUMTEXT',
												'LONGTEXT'=>'LONGTEXT',
												'BINARY'=>'BINARY',
												'VARBINARY'=>'VARBINARY',
												'TINYBLOB'=>'TINYBLOB',
												'MEDIUMBLOB'=>'MEDIUMBLOB',
												'BLOB'=>'BLOB',
												'LONGBLOB'=>'LONGBLOB',
												'ENUM'=>'ENUM',
												'SET'=>'SET'
												);
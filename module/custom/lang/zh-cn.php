<?php
$lang->custom->common				= '自定义字段';

/* 方法列表 */
$lang->custom->index				= '首页';
$lang->custom->create				= '创建新字段';
$lang->custom->edit					= '编辑字段';
$lang->custom->delete				= '删除字段';

/* 字段列表 */
$lang->custom->Field				= '名字';
$lang->custom->Type					= '类型';
$lang->custom->Length				= '长度/值';
$lang->custom->Default				= '默认';
$lang->custom->Null					= '空';
$lang->custom->Comment				= '注释';

/* 功能按钮 */

/* 交互提示 */
$lang->custom->confirmDelete    	= "您确定删除该字段吗？";

/* 模块提示 */
$lang->custom->infoCustom			='自定义公告字段';
$lang->custom->assetCustom			='自定义资产字段';
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
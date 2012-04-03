<?php
$lang->custom->common				= 'Custom Field';

/* 方法列表 */
$lang->custom->index				= 'Index';
$lang->custom->create				= 'Create';
$lang->custom->edit					= 'Edit';
$lang->custom->delete				= 'Delete';

/* 字段列表 */
$lang->custom->Field				= 'Field';
$lang->custom->Type					= 'Type';
$lang->custom->Length				= 'Length/Value';
$lang->custom->Default				= 'Default';
$lang->custom->Null					= 'Null';
$lang->custom->Comment				= 'Comment';

/* 功能按钮 */

/* 交互提示 */
$lang->custom->confirmDelete    	= "Are you sure?";

/* 模块提示 */
$lang->custom->infoCustom			='Info Custom Field';
$lang->custom->assetCustom			='Asset Custom Field';
$lang->custom->YES					='Yes';
$lang->custom->NO					='No';

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
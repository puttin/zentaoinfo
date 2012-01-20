<?php

global $lang;
$config->asset->createLib->requiredFields = 'name';
$config->asset->editLib->requiredFields   = 'name';
$config->asset->create->requiredFields = 'hostname';
$config->asset->edit->requiredFields   = 'hostname';
$config->asset->list->exportFields = 'id, lib, module, hostname, address, extendaddress, os, username, password, status, duty,
									 position, devicenumber, rootusername, rootpassword,
									 codeversion, name, serial, model, cpu, memory, disk,
									 graphics, price, netvalue, code, from, registdate,
									 lend, lenddate, returndate,assetcomment,use,
									 createdBy ,createdDate, lastEditedBy, lastEditedDate, editedCount';
$config->asset->list->allFields = 'id, lib, module, hostname, address, extendaddress, os, username, password, status, duty,
								 position, devicenumber, rootusername, rootpassword,
								 codeversion, name, serial, model, cpu, memory, disk,
								 graphics, price, netvalue, code, from, registdate,
								 lend, lenddate, returndate,assetcomment,use,
								 createdBy ,createdDate, lastEditedBy, lastEditedDate, editedCount';
$config->asset->list->defaultFields = 'id,hostname,address,username,password,status,duty,codeversion,module,use';

$config->asset->search['module']                   = 'asset';
$config->asset->search['fields']['hostname']       = $lang->asset->hostname;
$config->asset->search['fields']['os']             = $lang->asset->os;
$config->asset->search['fields']['username']       = $lang->asset->username;
$config->asset->search['fields']['password']       = $lang->asset->password;
$config->asset->search['fields']['address']        = $lang->asset->address;
$config->asset->search['fields']['status']         = $lang->asset->status;
$config->asset->search['fields']['extendaddress']  = $lang->asset->extendaddress;
$config->asset->search['fields']['duty']           = $lang->asset->duty;
$config->asset->search['fields']['position']       = $lang->asset->position;
$config->asset->search['fields']['id']             = $lang->asset->id;
$config->asset->search['fields']['lib']            = $lang->asset->lib;
$config->asset->search['fields']['module']         = $lang->asset->module;
$config->asset->search['fields']['devicenumber']   = $lang->asset->devicenumber;
$config->asset->search['fields']['rootusername']   = $lang->asset->rootusername;
$config->asset->search['fields']['rootpassword']   = $lang->asset->rootpassword;
$config->asset->search['fields']['codeversion']    = $lang->asset->codeversion;
$config->asset->search['fields']['name']           = $lang->asset->name;
$config->asset->search['fields']['serial']         = $lang->asset->serial;
$config->asset->search['fields']['model']          = $lang->asset->model;
$config->asset->search['fields']['cpu']            = $lang->asset->cpu;
$config->asset->search['fields']['memory']         = $lang->asset->memory;
$config->asset->search['fields']['disk']           = $lang->asset->disk;
$config->asset->search['fields']['graphics']       = $lang->asset->graphics;
$config->asset->search['fields']['price']          = $lang->asset->price;
$config->asset->search['fields']['netvalue']       = $lang->asset->netvalue;
$config->asset->search['fields']['code']           = $lang->asset->code;
$config->asset->search['fields']['from']           = $lang->asset->from;
$config->asset->search['fields']['registdate']     = $lang->asset->registdate;
$config->asset->search['fields']['lend']           = $lang->asset->lend;
$config->asset->search['fields']['lenddate']       = $lang->asset->lenddate;
$config->asset->search['fields']['returndate']     = $lang->asset->returndate;
$config->asset->search['fields']['createdBy']      = $lang->asset->createdBy;
$config->asset->search['fields']['createdDate']    = $lang->asset->createdDate;
$config->asset->search['fields']['lastEditedBy']   = $lang->asset->lastEditedBy;
$config->asset->search['fields']['lastEditedDate'] = $lang->asset->lastEditedDate;
$config->asset->search['fields']['editedCount']    = $lang->asset->editedCount;
$config->asset->search['fields']['assetcomment']   = $lang->asset->assetcomment;
$config->asset->search['fields']['use']            = $lang->asset->use;

$config->asset->search['params']['hostname']       = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['os']             = array('operator' => '=',       'control' => 'select', 'values' => $lang->asset->osList);
$config->asset->search['params']['username']       = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['password']       = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['address']        = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['extendaddress']  = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['status']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->asset->statusList);
$config->asset->search['params']['duty']           = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->asset->search['params']['position']       = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['lib']            = array('operator' => '=',       'control' => 'select', 'values' => '' );
$config->asset->search['params']['module']         = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->asset->search['params']['devicenumber']   = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['rootusername']   = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['rootpassword']   = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['codeversion']    = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['name']           = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['serial']         = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['model']          = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['cpu']            = array('operator' => '=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['memory']         = array('operator' => '=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['disk']           = array('operator' => '=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['graphics']       = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['price']          = array('operator' => '>=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['netvalue']       = array('operator' => '>=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['code']           = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['from']           = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['registdate']     = array('operator' => '>=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['lend']           = array('operator' => '=',       'control' => 'input', 'values' => 'users');
$config->asset->search['params']['lenddate']       = array('operator' => '>=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['returndate']     = array('operator' => '>=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['createdBy']      = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->asset->search['params']['createdDate']    = array('operator' => '>=',      'control' => 'input',  'values' => '');
$config->asset->search['params']['lastEditedBy']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->asset->search['params']['lastEditedDate'] = array('operator' => '>=',      'control' => 'input',  'values' => '');
$config->asset->search['params']['editedCount']    = array('operator' => '=',       'control' => 'input', 'values' => '');
$config->asset->search['params']['assetcomment']   = array('operator' => 'include',       'control' => 'input', 'values' => '');
$config->asset->search['params']['use']            = array('operator' => 'include',       'control' => 'input', 'values' => '');

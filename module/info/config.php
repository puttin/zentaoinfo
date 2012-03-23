<?php

global $lang;
$config->info->createLib->requiredFields = 'name';
$config->info->editLib->requiredFields   = 'name';
$config->info->create->requiredFields = 'title';
$config->info->edit->requiredFields   = 'title';
$config->info->editor->create = array('id' => 'content', 'tools' => 'fullTools');
$config->info->editor->edit   = array('id' => 'content', 'tools' => 'fullTools');
$config->info->list->exportFields = 'id, pri, lib, module, digest, keywords, title, content, createdBy, createdDate, lastEditedBy, lastEditedDate, editedCount, mailto';
$config->info->list->allFields = 'id, keywords, lib, module, createdBy ,createdDate,
								 lastEditedBy, lastEditedDate, deadline, editedCount,
								 pri, title, content, digest';
$config->info->list->defaultFields = 'id,pri,title,createdBy,createdDate,lastEditedBy,lastEditedDate';

$config->info->search['module']                   = 'info';
$config->info->search['fields']['title']          = $lang->info->title;
$config->info->search['fields']['module']         = $lang->info->module;
$config->info->search['fields']['id']             = $lang->info->id;
$config->info->search['fields']['lib']            = $lang->info->lib;
$config->info->search['fields']['content']        = $lang->info->content;
$config->info->search['fields']['createdBy']      = $lang->info->createdBy;
$config->info->search['fields']['createdDate']    = $lang->info->createdDate;
$config->info->search['fields']['lastEditedBy']   = $lang->info->lastEditedBy;
$config->info->search['fields']['lastEditedDate'] = $lang->info->lastEditedDate;
$config->info->search['fields']['keywords']       = $lang->info->keywords;
$config->info->search['fields']['digest']         = $lang->info->digest;
$config->info->search['fields']['editedCount']    = $lang->info->editedCount;
$config->info->search['fields']['viewedCount']    = $lang->info->viewedCount;

$config->info->search['params']['title']          = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->info->search['params']['keywords']       = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->info->search['params']['module']         = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->info->search['params']['lib']            = array('operator' => '=',       'control' => 'select', 'values' => '' );
$config->info->search['params']['digest']         = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->info->search['params']['content']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->info->search['params']['createdBy']      = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->info->search['params']['createdDate']    = array('operator' => '>=',      'control' => 'input',  'values' => '');
$config->info->search['params']['lastEditedBy']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->info->search['params']['lastEditedDate'] = array('operator' => '>=',      'control' => 'input',  'values' => '');
$config->info->search['params']['viewedCount']    = array('operator' => '>=',      'control' => 'input',  'values' => '0');
$config->info->search['params']['editedCount']    = array('operator' => '=',      'control' => 'input',  'values' => '0');

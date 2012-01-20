<?php

$config->info->createLib->requiredFields = 'name';
$config->info->editLib->requiredFields   = 'name';
$config->info->create->requiredFields = 'title';
$config->info->edit->requiredFields   = 'title';
$config->info->editor->create = array('id' => 'content', 'tools' => 'fullTools');
$config->info->editor->edit   = array('id' => 'content', 'tools' => 'fullTools');

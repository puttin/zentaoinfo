<?php
class infoModel extends model
{
    static $errors = array();
    public function addViewedCount($id,$table){
		$this->dao->update($table)->set('`viewedCount` = `viewedCount` + 1')->where('id')->eq($id)->exec();
	}
	private function createInfoLink($module)
	{
		$linkHtml = html::a(helper::createLink('info', 'browse', "libID={$module->root}&&moduleID={$module->id}"), $module->name, '_self', "id='module{$module->id}'");
		return $linkHtml;
	}
	private function createManageLink($module,$type='info')
	{
		static $users;
		if(empty($users)) $users = $this->loadModel('user')->getPairs('noletter');
		$linkHtml  = $module->name;
		if(common::hasPriv('info', 'TreeEdit')) $linkHtml .= ' ' . html::a(helper::createLink('info', 'TreeEdit',   "module={$module->id}"), $this->lang->tree->edit, '', 'class="iframe"');
		if(common::hasPriv('info', 'TreeManage')) $linkHtml .= ' ' . html::a(helper::createLink('info', 'TreeManage', "root={$module->root}&module={$module->id}&type=$type"), $this->lang->tree->child);
		if(common::hasPriv('info', 'TreeDelete')) $linkHtml .= ' ' . html::a(helper::createLink('info', 'TreeDelete', "root={$module->root}&module={$module->id}"), $this->lang->delete, 'hiddenwin');
		if(common::hasPriv('info', 'TreeUpdateOrder')) $linkHtml .= ' ' . html::input("orders[$module->id]", $module->order, 'style="width:30px;text-align:center"');
		return $linkHtml;
	}
	public function createInfo()
	{
		$now = helper::now();
		$info = fixer::input('post')
			->add('createdBy', $this->app->user->account)
			->add('createdDate', $now)
			->add('lastEditedDate', $now)
			->setDefault('module', 0)
			->setDefault('deadline','0000-00-00')
			->specialChars('title, digest, keywords')
			->cleanInt('module')
			->remove('files, labels')
			->get();
		$condition = "module = '$info->module'";
		$this->dao->insert(TABLE_INFO)
			->data($info)
			->autoCheck()
			->batchCheck($this->config->info->create->requiredFields, 'notempty')
			->check('title', 'unique', $condition)
			->exec();
		if(!dao::isError())
		{
			$infoID = $this->dao->lastInsertID();
			$this->loadModel('file')->saveUpload('info', $infoID);
			return $infoID;
		}
		return false;
	}
	public function createLib($type='info')
	{
		$lib = fixer::input('post')->stripTags('name')->add('type',$type)->get();
		$defaultLibID=$this->getDefaultLibId($type);
		if (!$defaultLibID){
			$this->clearDefaultLib($type);
			$lib->defaultlib='1';
		}
		$condition = "type = '$type'";
		$this->dao->insert(TABLE_INFOLIB)
			->data($lib)
			->autoCheck()
			->batchCheck($this->config->info->createLib->requiredFields, 'notempty')
			->check('name', 'unique',$condition)
			->exec();
		return $this->dao->lastInsertID();
	}
	public function getDefaultLibId($type='info')
	{
		$lib = $this->dao->select('id')->from(TABLE_INFOLIB)
			->where('defaultlib')->eq(1)
			->andWhere('type')->eq($type)
			->andWhere('deleted')->eq(0)
			->fetch();
		if (!$lib) return false;
		return $lib->id;
	}
	public function getLibs($type='info')
	{
		//此处有一个历史遗留问题,0.3版本以前的infolib库里无type列
		$test=$this->app->dbh->query('desc '.TABLE_INFOLIB.' type')->fetch(PDO::FETCH_OBJ);
		//print $test->Field.'<br />';
		if (!$test->Field) {
			$infolibs = $this->dao->select('id, name')->from(TABLE_INFOLIB)->where('deleted')->eq(0)->fetchPairs();
			//echo js::alert($this->lang->info->pleaseUpgrade);
		}
		else{
			$infolibs = $this->dao->select('id, name')->from(TABLE_INFOLIB)->where('deleted')->eq(0)->andWhere('type')->eq($type)->fetchPairs();
		}
//		while (list($key, $val) = each($test)) {
//			echo "$key => $val\n";
//		}
		return $infolibs;
	}
	public function getInfoById($infoID)
	{
		$info = $this->dao->select('*')
			->from(TABLE_INFO)
			->where('id')->eq((int)$infoID)->fetch();
		if(!$info) return false;
		$info->content = $this->loadModel('file')->setImgSize($info->content);
		foreach($info as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $info->$key = '';
		$info->files = $this->loadModel('file')->getByObject('info', $infoID);
        return $this->processInfo($info);
	}
	public function getLibById($libID)
	{
		return $this->dao->findByID($libID)->from(TABLE_INFOLIB)->fetch();
	}
	public function getModuleById($moduleID)
	{
		return $this->dao->findById((int)$moduleID)->from(TABLE_INFOMODULE)->fetch();
	}
	public function getAllChildId($moduleID,$type='info')
	{
		if($moduleID == 0) return array();
		$module = $this->getModuleById((int)$moduleID);
		return $this->dao->select('id')->from(TABLE_INFOMODULE)->where('path')->like($module->path . '%')->andWhere('type')->eq($type)->fetchPairs();
	}
	public function getInfos($libID, $module, $orderBy, $pager)
	{
        $yesterday = date("Y-m-d", strtotime("-1 day"));
		return $this->dao->select('*')->from(TABLE_INFO)
			->where('deleted')->eq(0)
			->beginIF(is_numeric($libID))->andWhere('lib')->eq($libID)->fi()
			->beginIF($module)->andWhere('module')->in($module)->fi()
			->andWhere('(`deadline` > "'.$yesterday.'" OR `deadline` IS NULL)')
			->andWhere('Stickie')->ne(2)
			->orderBy($orderBy)
			->page($pager)
			->fetchAll();
	}
	public function getParents($moduleID)
	{
		if($moduleID == 0) return array();
		$path = $this->dao->select('path')->from(TABLE_INFOMODULE)->where('id')->eq((int)$moduleID)->fetch('path');
		$path = trim($path, ',');
		if(!$path) return array();
		return $this->dao->select('*')->from(TABLE_INFOMODULE)->where('id')->in($path)->orderBy('grade')->fetchAll();
	}
	public function getSons($rootID, $moduleID, $type = 'root')
	{
		return $this->dao->select('*')->from(TABLE_INFOMODULE)
			->where('root')->eq((int)$rootID)
			->andWhere('parent')->eq((int)$moduleID)
			->andWhere('type')->eq($type)
			->orderBy('`order`')
			->fetchAll();
	}
	public function getLibPairs($param = 'all',$type='info')
	{
		$libs = array();
		$datas = $this->dao->select('id, name, deleted')
			->from(TABLE_INFOLIB)
			->where('type')->eq($type)
			->orderBy('id desc')
			->fetchAll();

		foreach($datas as $data)
		{
			if($param == 'nodeleted' and $data->deleted) continue;
			$libs[$data->id] = $data->name;
		}
		//$libs = array('' => '') +  $libs;
		return $libs;
	}
	public function getTreeMenu($rootID, $type = 'root', $startModule = 0, $userFunc, $extra = '')
	{
		$treeMenu = array();
		$stmt = $this->dbh->query($this->buildMenuQuery($rootID, $type, $startModule));
		while($module = $stmt->fetch())
		{
			$linkHtml = call_user_func($userFunc, $module, $extra);

			if(isset($treeMenu[$module->id]) and !empty($treeMenu[$module->id]))
			{
				if(!isset($treeMenu[$module->parent])) $treeMenu[$module->parent] = '';
				$treeMenu[$module->parent] .= "<li>$linkHtml";  
				$treeMenu[$module->parent] .= "<ul>".$treeMenu[$module->id]."</ul>\n";
			}
			else
			{
				if(isset($treeMenu[$module->parent]) and !empty($treeMenu[$module->parent]))
				{
					$treeMenu[$module->parent] .= "<li>$linkHtml\n";  
				}
				else
				{
					$treeMenu[$module->parent] = "<li>$linkHtml\n";  
				}    
			}
			$treeMenu[$module->parent] .= "</li>\n"; 
		}

		$lastMenu = "<ul id='tree'>" . @array_pop($treeMenu) . "</ul>\n";
		return $lastMenu; 
	}
	public function getOptionMenu($rootID, $type = 'info', $startModule = 0)
	{
		$treeMenu = array();
		$stmt = $this->dbh->query($this->buildMenuQuery($rootID, $type, $startModule));
		$modules = array();
		while($module = $stmt->fetch()) $modules[$module->id] = $module;

		foreach($modules as $module)
		{
			$parentModules = explode(',', $module->path);
			$moduleName = '/';
			foreach($parentModules as $parentModuleID)
			{
				if(empty($parentModuleID)) continue;
				$moduleName .= $modules[$parentModuleID]->name . '/';
			}
			$moduleName = rtrim($moduleName, '/');
			$moduleName .= "|$module->id\n";
			
			if(isset($treeMenu[$module->id]) and !empty($treeMenu[$module->id]))
			{
				if(isset($treeMenu[$module->parent]))
				{
					$treeMenu[$module->parent] .= $moduleName;
				}
				else
				{
					$treeMenu[$module->parent] = $moduleName;;
				}
				$treeMenu[$module->parent] .= $treeMenu[$module->id];
			}
			else
			{
				if(isset($treeMenu[$module->parent]) and !empty($treeMenu[$module->parent]))
				{
					$treeMenu[$module->parent] .= $moduleName;
				}
				else
				{
					$treeMenu[$module->parent] = $moduleName;
				}    
			}
		}

		$topMenu = @array_pop($treeMenu);
		$topMenu = explode("\n", trim($topMenu));
		$lastMenu[] = '/';
		foreach($topMenu as $menu)
		{
			if(!strpos($menu, '|')) continue;
			list($label, $moduleID) = explode('|', $menu);
			$lastMenu[$moduleID] = $label;
		}
		return $lastMenu;
	}
	public function getFieldPairs($fields,$type='info')
    {
        $fields = explode(',', $fields);
        foreach($fields as $key => $field)
        {
            $field = trim($field);
            $fields[$field] = $this->lang->$type->$field;
            unset($fields[$key]);
        }
        return $fields;
    }
	public function setMenu($libs, $libID, $type = 'info')
	{
		$currentModule = $this->app->getModuleName();
		$currentMethod = $this->app->getMethodName();

		$selectHtml = html::select('libID', $libs, $libID, "onchange=\"switchInfoLib(this.value, '$currentModule', '$currentMethod', '');\"");
		common::setMenuVars($this->lang->$type->menu, 'list', $selectHtml . $this->lang->arrow);
		foreach($this->lang->$type->menu as $key => $menu)
		{
			if($key != 'list') common::setMenuVars($this->lang->$type->menu, $key, $libID);
		}
	}
	private function buildMenuQuery($rootID, $type, $startModule)
	{
		/* Set the start module. */
		$startModulePath = '';
		if($startModule > 0)
		{
			$startModule = $this->getModuleById($startModule);
			if($startModule) $startModulePath = $startModule->path . '%';
		}

		return $this->dao->select('*')->from(TABLE_INFOMODULE)
			->where('root')->eq((int)$rootID)
			->andWhere('type')->eq($type)
			->beginIF($startModulePath)->andWhere('path')->like($startModulePath)->fi()
			->orderBy('grade desc, `order`')
			->get();
	}
	public function update($infoID)
	{
		$oldInfo = $this->getInfoById($infoID);
		$now = helper::now();
		$info = fixer::input('post')
			->cleanInt('module')
			->setDefault('module', 0)
			->setDefault('deadline','0000-00-00')
			->specialChars('title, digest, keywords')
			->remove('comment,files, labels')
			->removeIF(!common::hasPriv('info', 'HighlightAndStickie'),'stickie,highlight')
			->add('lastEditedBy',$this->app->user->account)
			->add('lastEditedDate',$now)
			->get();

		$condition = "lib = '$info->lib' AND module = '$info->module' AND id != '$infoID'";
		$this->dao->update(TABLE_INFO)->data($info)
			->autoCheck()
			->batchCheck($this->config->info->edit->requiredFields, 'notempty')
			->check('title', 'unique', $condition)
			->where('id')->eq((int)$infoID)
			->exec();
		$info->editedCount=$info->editedCount-1;
		if(!dao::isError()) return common::createChanges($oldInfo, $info);
	}
	public function updateLib($libID,$type)
	{
		$libID  = (int)$libID;
		$oldLib = $this->getLibById($libID);
		$lib = fixer::input('post')->stripTags('name')
				->add('type',$type)
				->setIF('$defaultlib==on','defaultlib','1')
				->setIF('$defaultlib==off','defaultlib','0')
				->get();
		//检测默认库
		$oldDefaultLibID=$this->getDefaultLibId();
		if ($libID==$oldDefaultLibID)
				$lib->defaultlib=1;
		else if ($lib->defaultlib=1){
			$this->clearDefaultLib($type);
		}
		$condition = "type = '$type' and id != '$libID'";
		$this->dao->update(TABLE_INFOLIB)
			->data($lib)
			->autoCheck()
			->batchCheck($this->config->info->editLib->requiredFields, 'notempty')
			->check('name', 'unique', $condition)
			->where('id')->eq($libID)
			->exec();
		if(!dao::isError()) return common::createChanges($oldLib, $lib);
	}
	public function updateTree($moduleID)
	{
		$module = fixer::input('post')->specialChars('name')->get();
		$self   = $this->getModuleById($moduleID);
		$parent = $this->getModuleById($this->post->parent);
		$childs = $this->getAllChildId($moduleID);
		$module->grade = $parent ? $parent->grade + 1 : 1;
		$this->dao->update(TABLE_INFOMODULE)->data($module)->autoCheck()->check('name', 'notempty')->where('id')->eq($moduleID)->exec();
		$this->dao->update(TABLE_INFOMODULE)->set('grade = grade + 1')->where('id')->in($childs)->andWhere('id')->ne($moduleID)->exec();
		$this->dao->update(TABLE_INFOMODULE)->set('owner')->eq($this->post->owner)->where('id')->in($childs)->andWhere('owner')->eq('')->exec();
		$this->dao->update(TABLE_INFOMODULE)->set('owner')->eq($this->post->owner)->where('id')->in($childs)->andWhere('owner')->eq($self->owner)->exec();
		$this->fixModulePath();
	}
	public function updateOrder($orders)
	{
		foreach($orders as $moduleID => $order)
		{
			$this->dao->update(TABLE_INFOMODULE)->set('`order`')->eq($order)->where('id')->eq((int)$moduleID)->limit(1)->exec();
		}
	}
	private function clearDefaultLib($type='info')
	{
		$cleanDefaultLib->defaultlib=0;
		$this->dao->update(TABLE_INFOLIB)
			->data($cleanDefaultLib)
			->where('type')->eq($type)
			->autoCheck()
			->exec();
	}
	public function deleteModule($moduleID)
	{
		$module = $this->getModuleById($moduleID);
		$childs = $this->getAllChildId($moduleID);

		$this->dao->update(TABLE_INFOMODULE)->set('grade = grade - 1')->where('id')->in($childs)->exec();                 // Update grade of all childs.
		$this->dao->update(TABLE_INFOMODULE)->set('parent')->eq($module->parent)->where('parent')->eq($moduleID)->exec(); // Update the parent of sons to my parent.
		$this->dao->delete()->from(TABLE_INFOMODULE)->where('id')->eq($moduleID)->exec();                                 // Delete my self.
		$this->fixModulePath();

		if($module->type == 'info') $this->dao->update(TABLE_INFO)->set('module')->eq($module->parent)->where('module')->eq($moduleID)->exec();
	}
	public function manageChild($rootID, $type, $parentModuleID, $childs)
	{
		$parentModule = $this->getModuleById($parentModuleID);
		if($parentModule)
		{
			$grade      = $parentModule->grade + 1;
			$parentPath = $parentModule->path;
		}
		else
		{
			$grade      = 1;
			$parentPath = ',';
		}
		$i = 1;
		foreach($childs as $moduleID => $moduleName)
		{
			if(empty($moduleName)) continue;

			/* The new modules. */
			if(is_numeric($moduleID))
			{
				$module->root    = $rootID;
				$module->name    = strip_tags($moduleName);
				$module->parent  = $parentModuleID;
				$module->grade   = $grade;
				$module->type    = $type;
				$module->order   = $this->post->maxOrder + $i * 10;
				$this->dao->insert(TABLE_INFOMODULE)->data($module)->exec();
				$moduleID  = $this->dao->lastInsertID();
				$childPath = $parentPath . "$moduleID,";
				$this->dao->update(TABLE_INFOMODULE)->set('path')->eq($childPath)->where('id')->eq($moduleID)->limit(1)->exec();
				$i ++;
			}
			else
			{
				$moduleID = str_replace('id', '', $moduleID);
				$this->dao->update(TABLE_INFOMODULE)->set('name')->eq(strip_tags($moduleName))->where('id')->eq($moduleID)->limit(1)->exec();
			}
		}
	}
	private function processInfos($infos)
    {
        $today = helper::today();
        foreach($infos as $info)
        {
            /* Delayed or not. */
            if($info->deadline != '0000-00-00')
            {
                $delay = helper::diffDate($today, $info->deadline);
                if($delay > 0) $info->delay = $delay;
            }
        }
        return $infos;
    }
    private function processInfo($info)
    {
        $today = helper::today();
       
        /* Delayed or not?. */
        if($info->deadline != '0000-00-00')
        {
            $delay = helper::diffDate($today, $info->deadline);
        	if($delay > 0) $info->delay = $delay;            
        } 
        return $info;
    }
	public function fixModulePath()
	{
		/* Get the max grade. */
		$maxGrade = $this->dao->select('MAX(grade) AS grade')->from(TABLE_INFOMODULE)->fetch('grade');
		$modules  = array();

		/* Cycle ervery grade. */
		for($grade = 1; $grade <= $maxGrade; $grade ++)
		{
			/* Modules of current grade. */
			$gradeModules = $this->dao->select('id, parent, grade')->from(TABLE_INFOMODULE)->where('grade')->eq($grade)->fetchAll('id');
			foreach($gradeModules as $moduleID => $module)
			{
				if($grade == 1)
				{
					$module->path = ",$moduleID,";
				}
				else
				{
					/* Get the parent module to compute path and grade of my self. */
					if(isset($modules[$module->parent]))
					{
						$module->path  = $modules[$module->parent]->path . "$moduleID,";
						$module->grade = $modules[$module->parent]->grade + 1;
					}
				}
			}
			$modules += $gradeModules;
		}

		/* Save modules to database. */
		foreach($modules as $moduleID => $module)
		{
			$this->dao->update(TABLE_INFOMODULE)->data($module)->where('id')->eq($module->id)->limit(1)->exec();
		}
	}
	public function createRemind($actionID,$account,$type)
	{
		$remind->actionID=$actionID;
		$remind->account=$account;
		$remind->type=$type;
		$this->dao->insert(TABLE_INFOREMIND)
			->data($remind)
			->autoCheck()
			->batchCheck('actionID,account,type', 'notempty')
			->exec();
		if(!dao::isError())
		{
			$remindID = $this->dao->lastInsertID();
			return $remindID;
		}
		return false;
	}
	public function deleteRemind($actionID)
	{
		$this->dao->delete()->from(TABLE_INFOREMIND)->where('actionID')->eq($actionID)->exec();
		if(!dao::isError())
		{
			return true;
		}
		return false;
	}
	public function execute($fromVersion)
	{
		if($fromVersion == '0_1'){
			$this->upgradeFrom0_1To0_2();
			$this->upgradeFrom0_2To0_3();
			$this->upgradeFrom0_3To0_3_1();
		}
		elseif ($fromVersion == '0_2'){
			$this->upgradeFrom0_2To0_3();
			$this->upgradeFrom0_3To0_3_1();
		}
		elseif ($fromVersion == '0_3'){
			$this->upgradeFrom0_3To0_3_1();
		}
	}
	private function execSQL($sqlFile)
    {
        $mysqlVersion = $this->loadModel('install')->getMysqlVersion();

        /* Read the sql file to lines, remove the comment lines, then join theme by ';'. */
        $sqls = explode("\n", file_get_contents($sqlFile));
        foreach($sqls as $key => $line) 
        {
            $line       = trim($line);
            $sqls[$key] = $line;
            if(strpos($line, '--') !== false or empty($line)) unset($sqls[$key]);
        }
        $sqls = explode(';', join("\n", $sqls));

        foreach($sqls as $sql)
        {
            $sql = trim($sql);
            if(empty($sql)) continue;

            if($mysqlVersion <= 4.1)
            {
                $sql = str_replace('DEFAULT CHARSET=utf8', '', $sql);
                $sql = str_replace('CHARACTER SET utf8 COLLATE utf8_general_ci', '', $sql);
            }

            $sql = str_replace('zt_', $this->config->db->prefix, $sql);
            try
            {
                $this->dbh->exec($sql);
            }
            catch (PDOException $e) 
            {
                self::$errors[] = $e->getMessage() . "<p>The sql is: $sql</p>";
            }
        }
    }
	public function getUpgradeFile($version)
    {
        return $this->app->getModuleExtPath('extension','info') . 'db' . $this->app->getPathFix() . 'update' . $version . '.sql';
    }
	private function upgradeFrom0_1To0_2()
	{
		$this->execSQL($this->getUpgradeFile('0.2'));
		$this->setVersion('0.2');
	}
	private function upgradeFrom0_2To0_3()
	{
		$this->execSQL($this->getUpgradeFile('0.3'));
		$this->setVersion('0.3');
	}
	private function upgradeFrom0_3To0_3_1()
	{
		$this->execSQL($this->getUpgradeFile('0.3.1'));
		$this->setVersion('0.3.1');
	}
	/**
	 * Judge any error occers.
	 * 
	 * @access public
	 * @return bool
	 */
	public function isError()
	{
		return !empty(self::$errors);
	}

	/**
	 * Get errors during the upgrading.
	 * 
	 * @access public
	 * @return array
	 */
	public function getError()
	{
		$errors = self::$errors;
		self::$errors = array();
		return $errors;
	}
	public function setVersion($version)
    {
        $item->company = 0;
        $item->owner   = 'system';
        $item->section = 'global';
        $item->key     = 'infoplugin';
        $item->value   = $version;

        $config = $this->dao->select('id, value')->from(TABLE_CONFIG)
            ->where('company')->eq(0)
            ->andWhere('owner')->eq('system')
            ->andWhere('section')->eq('global')
            ->andWhere('`key`')->eq('infoplugin')
            ->fetch('', $autoComapny = false);
        if(!$config)
        {
            $this->dao->insert(TABLE_CONFIG)->data($item)->exec($autoCompany = false);
        }
        else{
        	$this->dao->update(TABLE_CONFIG)->data($item)->where('id')->eq($config->id)->exec($autoCompany = false);
        }
    }
    public function getVersion()
    {
        $config = $this->dao->select('id, value')->from(TABLE_CONFIG)
            ->where('company')->eq(0)
            ->andWhere('owner')->eq('system')
            ->andWhere('section')->eq('global')
            ->andWhere('`key`')->eq('infoplugin')
            ->fetch('', $autoComapny = false);
        if(!$config)
        {
            return false;
        }
        else{
        	return $config->value;
        }
    }
//    public function getModuleInfos( $moduleIds = 0, $orderBy = 'id_desc', $pager = null)
//    {
//        return $this->dao->select('*')->from(TABLE_INFO)
//            ->where('module')->eq((int)$moduleIds)
//            ->andWhere('deleted')->eq(0)
//            ->orderBy($orderBy)->page($pager)->fetchAll();
//    }
}
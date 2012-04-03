<?php
class asset extends control{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('tree');
		$this->loadModel('user');
		$this->loadModel('action');
		$this->loadModel('info');
		$this->assetlibs = $this->info->getLibs('asset');
	}
	public function index()
	{
		$this->locate($this->createLink('asset', 'browse'));
	}
	public function browse($libID = 'default', $moduleID = 0, $browseType = 'bymodule', $param = 0, $orderBy = 'lastEditedDate_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* Set browseType.*/ 
		$browseType = strtolower($browseType);
		$queryID    = ($browseType == 'bysearch') ? (int)$param : 0;
		if($libID=='default')
		{
			$libID=$this->info->getDefaultLibId('asset');
		}
		$libName = $this->assetlibs[$libID];

		/* Set menu, save session. */
		$this->info->setMenu($this->assetlibs, $libID,'asset');
		$this->session->set('assetList',   $this->app->getURI(true));
		
		/* Process the order by field. */
		if(!$orderBy) $orderBy = $this->cookie->assetOrder ? $this->cookie->assetOrder : 'lastEditedDate_desc';
		setcookie('assetOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
		
		/* Load pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);
		
		/* Get infos. */
		$modules = 0;
		$assets=array();
		if($browseType == 'all')
		{
			$assets = $this->dao->select('*')->from(TABLE_INFOASSET)->Where('deleted')->eq(0)
				->orderBy($orderBy)->page($pager)->fetchAll();
		}
		elseif($browseType == 'myduty')
		{
			if($moduleID) $modules = $this->info->getAllChildId($moduleID,'asset');
			$assets = $this->dao->findByduty($this->app->user->account)->from(TABLE_INFOASSET)
					->beginIF(is_numeric($libID))->andWhere('lib')->eq($libID)->fi()
					->beginIF($modules)->andWhere('module')->in($modules)->fi()
					->andWhere('deleted')->eq(0)
					->orderBy($orderBy)
					->page($pager)->fetchAll();
		}
		elseif($browseType == 'lendtome')
		{
			if($moduleID) $modules = $this->info->getAllChildId($moduleID,'asset');
			$assets = $this->dao->findBylend($this->app->user->account)->from(TABLE_INFOASSET)
					->beginIF(is_numeric($libID))->andWhere('lib')->eq($libID)->fi()
					->beginIF($modules)->andWhere('module')->in($modules)->fi()
					->andWhere('deleted')->eq(0)
					->orderBy($orderBy)
					->page($pager)->fetchAll();
		}
		elseif($browseType == "bymodule")
		{
			if($moduleID) $modules = $this->info->getAllChildId($moduleID,'asset');
			$assets = $this->asset->getAssets( $libID, $modules, $orderBy, $pager);
		}
		elseif($browseType == "bysearch")
		{
			if($queryID)
			{
				$query = $this->loadModel('search')->getQuery($queryID);
				if($query)
				{
					$this->session->set('assetQuery', $query->sql);
					$this->session->set('assetForm', $query->form);
				}
				else
				{
					$this->session->set('assetQuery', ' 1 = 1');
				}
			}
			else
			{
				if($this->session->assetQuery == false) $this->session->set('assetQuery', ' 1 = 1');
			}
			$assetQuery=$this->session->assetQuery;
			$assets = $this->dao->select('*')->from(TABLE_INFOASSET)->where($assetQuery)
			->andWhere('deleted')->eq(0)
			->orderBy($orderBy)->page($pager)->fetchAll();
		}
		/* Process the sql, get the conditon partion, save it to session. Thus the report page can use the same condition. */
		$sql = explode('WHERE', $this->dao->get());
		$sql = explode('ORDER', $sql[1]);
		$this->session->set('assetReportCondition', $sql[0]);
		
		/* Get custom fields. */
		$customFields = $this->cookie->assetFields != false ? $this->cookie->assetFields : $this->config->asset->list->defaultFields;
		$customed     = !($customFields == $this->config->asset->list->defaultFields);
 
		/* If customed, get related name or titles. */
		if($customed)
		{
			/* Get related objects id lists. */
			$relatedModuleIdList   = array();
			$relatedLibIdList  = array();

			foreach($assets as $asset)
			{
				$relatedModuleIdList[$asset->module]   = $asset->module;
				$relatedLibIdList[$asset->lib] = $asset->lib;
			}

			/* Get related objects title or names. */
			$relatedModules   = $this->dao->select('id, name')->from(TABLE_INFOMODULE)->where('id')->in($relatedModuleIdList)->fetchPairs();
			$relatedLibs  = $this->dao->select('id, name')->from(TABLE_INFOLIB)->where('id')->in($relatedLibIdList)->fetchPairs();

			foreach($assets as $asset)
			{
				/* fill some field with useful value. */
				if(isset($relatedModules[$asset->module]))    $asset->module       = $relatedModules[$asset->module];
				if(isset($relatedLibs[$asset->lib]))  $asset->lib      = $relatedLibs[$asset->lib];
			}
		}
		
		//*********************************************************************************************
		/* Build the search form. */
		$this->config->asset->search['actionURL'] = $this->createLink('asset', 'browse', "libID=$libID&moduleID=$moduleID&browseType=bySearch&queryID=myQueryID");
		$this->config->asset->search['queryID']   = $queryID;
		$this->config->asset->search['params']['lib']['values']     = array(''=>'') + $this->assetlibs;

		/* Get the modules. */
		$moduleOptionMenu = $this->info->getOptionMenu($libID, 'asset', $startModuleID = 0);
		$this->config->asset->search['params']['module']['values']        = array(''=>'') + $moduleOptionMenu;
		$this->view->searchForm = $this->fetch('search', 'buildForm', $this->config->asset->search);
		//*********************************************************************************************
		
		$relatedModuleIdList   = array();
		foreach($assets as $asset)
		{
			$relatedModuleIdList[$asset->module]   = $asset->module;
		}
		$relatedModules   = $this->dao->select('id, name')->from(TABLE_INFOMODULE)->where('id')->in($relatedModuleIdList)->fetchPairs();
		foreach($assets as $asset)
		{
			/* fill some field with useful value. */
			if(isset($relatedModules[$asset->module]))    $asset->module       = $relatedModules[$asset->module];
		}
		
		$users = $this->user->getPairs('noletter');
		if ($browseType == 'all') $this->view->header->title = $this->lang->asset->index;
		else{
			$this->view->header->title = $this->assetlibs[$libID] . $this->lang->colon . $this->lang->asset->index;
			$this->view->position[]    = html::a($this->createLink('asset', 'browse', "libID=$libID"), $libName);
		}
		$this->view->position[]    = $this->lang->asset->list;
		$this->view->moduleTree  = $this->info->getTreeMenu($libID, $viewType = 'asset', $startModuleID = 0, array('assetModel', 'createAssetLink'));
		$this->view->treeClass   = $browseType == 'bymodule' ? '' : 'hidden';
		$this->view->browseType  = $browseType;
		$this->view->moduleID    = $moduleID;
		$this->view->libID       = $libID;
		$this->view->assets      = $assets;
		$this->view->users       = $users;
		$this->view->pager       = $pager;
		$this->view->param       = $param;
		$this->view->orderBy     = $orderBy;
		$this->view->customed    = $customed;
		$this->view->type        = 'asset';
		$this->view->customFields= explode(',', str_replace(' ', '', trim($customFields)));
		$this->display();
	}
	public function view($assetID)
	{
		$this->info->addViewedCount($assetID,TABLE_INFOASSET);
		$asset = $this->asset->getAssetById($assetID);
		if(!$asset) die(js::error($this->lang->notFound) . js::locate('back'));

		$products = array('0'=>'')+$this->loadModel('product')->getPairs();
		$projects = array('0'=>'');
		if ($asset->product != '0'){
			$projects += $this->loadModel('product')->getProjectPairs($asset->product);
		}
		
		/* Set menu. */
		$libID=$asset->lib;
		$this->info->setMenu($this->assetlibs, $libID, 'asset');

		$libName = $this->assetlibs[$libID];
		$productName=$products[$asset->product];
		$projectName=$projects[$asset->project];

		/* Header and positon. */
		$this->view->header->title = $this->assetlibs[$libID] . $this->lang->colon . $this->lang->asset->view;
		$this->view->position[]    = html::a($this->createLink('asset', 'browse', "libID=$libID"), $libName);
		$this->view->position[]    = $this->lang->asset->view;
		
		/* Custom Field */
		$customs=$this->app->dbh->query("SHOW FULL COLUMNS FROM  `".TABLE_INFOASSET."` like 'custom_%'")->fetchAll(PDO::FETCH_OBJ);
		$this->view->customs          = $customs;

		/* Assign. */
		$this->view->modulePath  = $this->info->getParents($asset->module);
		$this->view->asset       = $asset;
		$this->view->moduleID    = $asset->module;
		$this->view->libID       = $libID;
		$this->view->libName     = $libName;
		$this->view->productName = $productName;
		$this->view->projectName = $projectName;
		$this->view->type        = 'asset';
		$this->view->users       = $this->user->getPairs('noletter');
		$this->view->actions     = $this->action->getList('asset', $assetID);

		$this->display();
	}
	public function create($libID, $moduleID = 0, $extras = '')
	{
		if (!$libID){
			echo js::alert($this->lang->asset->noLib);
			die(js::locate($this->createLink('asset', 'browse'), 'parent'));
		}
		if(!empty($_POST))
		{
			$assetID = $this->asset->createAsset();
			if(dao::isError()) die(js::error(dao::getError()));
			$actionID = $this->action->create('asset', $assetID, 'Created');

			$vars = "libID=$libID&moduleID={$this->post->module}";
			$link = $this->createLink('asset', 'browse', $vars);
			die(js::locate($link, 'parent'));
		}

		/* According the from, set menus. */
		$this->info->setMenu($this->assetlibs, $libID,'asset');
		
		/* Init vars. */
		$hostname       = '';
		$address        = '';
		$extendaddress  = '';
		$os             = '';
		$username       = '';
		$password       = '';
		$status         = '0';
		$duty           = '';
		$position       = '';
		$devicenumber   = '';
		$rootusername   = '';
		$rootpassword   = '';
		$codeversion    = '';
		$name           = '';
		$serial         = '';
		$model          = '';
		$cpu            = '';
		$memory         = '';
		$disk           = '';
		$graphics       = '';
		$price          = '0';
		$netvalue       = '0';
		$code           = '';
		$from           = '';
		$lend           = '';
		$lenddate       = '0000-00-00';
		$returndate     = '0000-00-00';
		$assetcomment   = '';
		$use            = '';
		$product        = '0';
		$project        = '0';
		
		/* Custom Field */
		$customs=$this->app->dbh->query("SHOW FULL COLUMNS FROM  `".TABLE_INFOASSET."` like 'custom_%'")->fetchAll(PDO::FETCH_OBJ);
		foreach($customs as $custom) {
			if (strpos($custom->Type,'(')!==false)
				$custom->Length= substr($custom->Type,strpos($custom->Type,'(')+1,strpos($custom->Type,')')-strpos($custom->Type,'(')-1);
			else
				$custom->Length = 0;
			$custom->Type = strtoupper(substr($custom->Type,0,strpos($custom->Type,'(')));
			${$custom->Field} = $custom->Default;
		}
		$this->view->customs          = $customs;
		
		/* Parse the extras. */
		$extras = str_replace(array(',', ' '), array('&', ''), $extras);
		parse_str($extras);
		
		/* If assetID setted, use this asset as template. */
		if(isset($assetID)) 
		{
			$asset = $this->asset->getAssetById($assetID);
			extract((array)$asset);
			$hostname       = $asset->hostname;
			$address        = $asset->address;
			$extendaddress  = $asset->extendaddress;
			$os             = $asset->os;
			$username       = $asset->username;
			$password       = $asset->password;
			$status         = $asset->status;
			$duty           = $asset->duty;
			$position       = $asset->position;
			$devicenumber   = $asset->devicenumber;
			$rootusername   = $asset->rootusername;
			$rootpassword   = $asset->rootpassword;
			$codeversion    = $asset->codeversion;
			$name           = $asset->name;
			$serial         = $asset->serial;
			$model          = $asset->model;
			$cpu            = $asset->cpu;
			$memory         = $asset->memory;
			$disk           = $asset->disk;
			$graphics       = $asset->graphics;
			$price          = $asset->price;
			$netvalue       = $asset->netvalue;
			$code           = $asset->code;
			$from           = $asset->from;
			$lend           = $asset->lend;
			$lenddate       = $asset->lenddate;
			$returndate     = $asset->returndate;
			$assetcomment   = $asset->assetcomment;
			$use            = $asset->use;
			$product        = $asset->product;
			$project        = $asset->project;
			foreach($customs as $custom) {
				${$custom->Field} = $asset->{$custom->Field};
			}
		}
		
		/* Get the modules. */
		$moduleOptionMenu = $this->info->getOptionMenu($libID, 'asset', $startModuleID = 0);
		$products = array(''=>'')+$this->loadModel('product')->getPairs();
		$projects = array();
		if ($product != '0'){
			$projects += $this->loadModel('product')->getProjectPairs($product);
		}

		$this->view->header->title = $this->assetlibs[$libID] . $this->lang->colon . $this->lang->asset->create;
		$this->view->position[]    = $this->lang->asset->create;

		/* Init vars. */
		$this->view->products   = $products;
		$this->view->projects   = $projects;
		
		$this->view->users            = $this->user->getPairs('nodeleted');
		$this->view->libID            = $libID;
		$this->view->libs             = $this->info->getLibPairs($params = 'nodeleted','asset');
		$this->view->moduleOptionMenu = $moduleOptionMenu;
		$this->view->moduleID         = $moduleID;
		$this->view->type             = 'asset';
		
		$this->view->hostname         = $hostname;
		$this->view->address          = $address;
		$this->view->extendaddress    = $extendaddress;
		$this->view->os               = $os;
		$this->view->username         = $username;
		$this->view->password         = $password;
		$this->view->status           = $status;
		$this->view->duty             = $duty;
		$this->view->assetposition    = $position;
		$this->view->devicenumber     = $devicenumber;
		$this->view->rootusername     = $rootusername;
		$this->view->rootpassword     = $rootpassword;
		$this->view->codeversion      = $codeversion;
		$this->view->name             = $name;
		$this->view->serial           = $serial;
		$this->view->model            = $model;
		$this->view->cpu              = $cpu;
		$this->view->memory           = $memory;
		$this->view->disk             = $disk;
		$this->view->graphics         = $graphics;
		$this->view->price            = $price;
		$this->view->netvalue         = $netvalue;
		$this->view->code             = $code;
		$this->view->from             = $from;
		$this->view->lend             = $lend;
		$this->view->lenddate         = $lenddate;
		$this->view->returndate       = $returndate;
		$this->view->assetcomment     = $assetcomment;
		$this->view->use              = $use;
		$this->view->product          = $product;
		$this->view->project          = $project;
		foreach($customs as $custom) {
			$this->view->{$custom->Field} = ${$custom->Field};
		}

		$this->display();
	}
	public function edit($assetID)
	{
		if(!empty($_POST))
		{
			$changes  = $this->asset->update($assetID);
			if(dao::isError()) die(js::error(dao::getError()));
			if($this->post->comment != '' or !empty($changes))
			{
				$action = !empty($changes) ? 'Edited' : 'Commented';
				$fileAction = '';
				$actionID = $this->action->create('asset', $assetID, $action, $fileAction . $this->post->comment);
				$this->action->logHistory($actionID, $changes);
			}
			die(js::locate($this->createLink('asset', 'view', "assetID=$assetID"), 'parent'));
		}

		/* Get the info of bug, current product and modue. */
		$asset             = $this->asset->getAssetById($assetID);
		$libID       = $asset->lib;
		$currentModuleID = $asset->module;

		/* Custom Field */
		$customs=$this->app->dbh->query("SHOW FULL COLUMNS FROM  `".TABLE_INFOASSET."` like 'custom_%'")->fetchAll(PDO::FETCH_OBJ);
		foreach($customs as $custom) {
			if (strpos($custom->Type,'(')!==false)
				$custom->Length= substr($custom->Type,strpos($custom->Type,'(')+1,strpos($custom->Type,')')-strpos($custom->Type,'(')-1);
			else
				$custom->Length = 0;
			$custom->Type = strtoupper(substr($custom->Type,0,strpos($custom->Type,'(')));
		}
		$this->view->customs          = $customs;
		
		/* Set the menu. */
		$this->info->setMenu($this->assetlibs, $libID,'asset');
		$products = array(''=>'')+$this->loadModel('product')->getPairs();
		$projects = array();
		if ($asset->product != '0'){
			$projects += $this->loadModel('product')->getProjectPairs($asset->product);
		}

		/* Set header and position. */
		$this->view->header->title = $this->assetlibs[$libID] . $this->lang->colon . $this->lang->asset->edit;
		$this->view->position[]    = html::a($this->createLink('asset', 'browse', "libID=$libID"), $this->assetlibs[$libID]);
		$this->view->position[]    = $this->lang->asset->edit;

		/* Assign. */
		$this->view->products   = $products;
		$this->view->projects   = $projects;
		$this->view->asset            = $asset;
		$this->view->libID            = $libID;
		$this->view->moduleOptionMenu = $this->info->getOptionMenu($libID,'asset', $startModuleID = 0);
		$this->view->currentModuleID  = $currentModuleID;
		$this->view->libs             = $this->info->getLibPairs('all','asset');
		$this->view->users            = $this->user->getPairs('noclosed,nodeleted');
		$this->view->actions          = $this->action->getList('asset', $assetID);
		$this->view->type             = 'asset';

		$this->display();
	}
	public function delete($assetID, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->asset->confirmDelete, inlink('delete', "assetID=$assetID&confirm=yes")));
		}
		else
		{
			$this->asset->delete(TABLE_INFOASSET, $assetID);
			die(js::locate($this->session->assetList, 'parent'));
		}
	}
	public function customFields()
	{
		if($_POST)
		{
			$customFields = $this->post->customFields;
			$customFields = join(',', $customFields);
			setcookie('assetFields', $customFields, $this->config->cookieLife, $this->config->webRoot);
			die(js::reload('parent'));
		}

		$customFields = $this->cookie->assetFields ? $this->cookie->assetFields : $this->config->asset->list->defaultFields;

		$this->view->allFields     = $this->info->getFieldPairs($this->config->asset->list->allFields,'asset');
		$this->view->customFields  = $this->info->getFieldPairs($customFields,'asset');
		$this->view->defaultFields = $this->info->getFieldPairs($this->config->asset->list->defaultFields,'asset');
		die($this->display());
	}
	public function export($productID, $orderBy)
	{
		if($_POST)
		{
			$assetLang   = $this->lang->asset;
			$assetConfig = $this->config->asset;

			/* Create field lists. */
			$fields = explode(',', $assetConfig->list->exportFields);
			foreach($fields as $key => $fieldName)
			{
				$fieldName = trim($fieldName);
				$fields[$fieldName] = isset($assetLang->$fieldName) ? $assetLang->$fieldName : $fieldName;
				unset($fields[$key]);
			}

			/* Get assets. */
			$assets = $this->dao->select('*')->from(TABLE_INFOASSET)->alias('t1')->where($this->session->assetReportCondition)->orderBy($orderBy)->fetchAll('id');
			
			/* Get users, libs. */
			$users    = $this->loadModel('user')->getPairs('noletter');
			$libs = $this->info->getLibPairs('all','asset');

			/* Get related objects id lists. */
			$relatedModuleIdList = array();

			foreach($assets as $asset)
			{
				$relatedModuleIdList[$asset->module]    = $asset->module;
			}

			/* Get related objects title or names. */
			$relatedModules = $this->dao->select('id, name')->from(TABLE_INFOMODULE)->where('id')->in($relatedModuleIdList)->fetchPairs();

			foreach($assets as $asset)
			{
				if($this->post->fileType == 'csv')
				{
					$asset->hostname = htmlspecialchars_decode($asset->hostname);
					$asset->hostname = str_replace('"', '""', $asset->hostname);
				}

				/* fill some field with useful value. */
				if(isset($libs[$asset->lib]))                     $asset->lib          = $libs[$asset->lib];
				if(isset($relatedModules[$asset->module]))        $asset->module       = $relatedModules[$asset->module];
				if(isset($assetLang->osList[$asset->os]))         $asset->os           = $assetLang->osList[$asset->os];
				if(isset($assetLang->statusList[$asset->status])) $asset->status       = $assetLang->statusList[$asset->status];
				if(isset($users[$asset->createdBy]))              $asset->createdBy    = $users[$asset->createdBy];
				if(isset($users[$asset->lastEditedBy]))           $asset->lastEditedBy = $users[$asset->lastEditedBy];

				$asset->createdDate     = substr($asset->createdDate,     0, 10);
				$asset->lastEditedDate = substr($asset->lastEditedDate, 0, 10);

				/* drop some field that is not needed. */
				unset($asset->company);
				unset($asset->deleted);
			}

			$this->post->set('fields', $fields);
			$this->post->set('rows', $assets);
			$this->fetch('file', 'export2' . $this->post->fileType, $_POST);
		}

		$this->display();
	}
}

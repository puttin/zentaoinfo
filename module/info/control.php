<?php
class info extends control
{
	const NEW_CHILD_COUNT = 5;
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('tree');
		$this->loadModel('user');
		$this->loadModel('action');
		$this->infolibs = $this->info->getInfoLibs();
	}
	public function index()
	{
		$this->locate($this->createLink('info', 'browse'));
	}
	public function browse($libID = 'default', $moduleID = 0, $browseType = 'bymodule', $param = 0, $orderBy = 'lastEditedDate_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
	{
		/* Set browseType.*/ 
		$browseType = strtolower($browseType);
		$queryID    = ($browseType == 'bysearch') ? (int)$param : 0;
		if($libID=='default')
		{
			$libID=$this->info->getDefaultLibId();
		}
//		if (!$libID){
//			$browseType = 'all';
//		}

		/* Set menu, save session. */
		$this->info->setMenu($this->infolibs, $libID,'info');
		$this->session->set('infoList',   $this->app->getURI(true));
		
		/* Process the order by field. */
		if(!$orderBy) $orderBy = $this->cookie->qaBugOrder ? $this->cookie->qaBugOrder : 'lastEditedDate_desc';
		setcookie('qaBugOrder', $orderBy, $this->config->cookieLife, $this->config->webRoot);
		
		/* Load pager. */
		$this->app->loadClass('pager', $static = true);
		$pager = pager::init($recTotal, $recPerPage, $pageID);
		
		/* Get infos. */
		$modules = 0;
		$infos=array();
		$tmpinfos=array();
		$infos = $this->dao->select('*')->from(TABLE_INFO)->Where('deleted')->eq(0)
					->andWhere('Stickie')->eq(2)->orderBy($orderBy)->fetchAll();
		if($browseType == 'all')
		{
			$tmpinfos = $this->dao->select('*')->from(TABLE_INFO)->Where('deleted')->eq(0)
				->andWhere('Stickie')->ne(2)->orderBy('Stickie_desc,'.$orderBy)->page($pager)->fetchAll();
		}
		elseif($browseType == "bymodule")
		{
			$browseType = "bymodule";
			if($moduleID) $modules = $this->info->getAllChildId($moduleID);
			$tmpinfos = $this->info->getInfos( $libID, $modules, 'Stickie_desc,'.$orderBy, $pager);
		}
		elseif($browseType == "bysearch")
		{
			if($queryID)
			{
				$query = $this->loadModel('search')->getQuery($queryID);
				if($query)
				{
					$this->session->set('infoQuery', $query->sql);
					$this->session->set('infoForm', $query->form);
				}
				else
				{
					$this->session->set('infoQuery', ' 1 = 1');
				}
			}
			else
			{
				if($this->session->infoQuery == false) $this->session->set('infoQuery', ' 1 = 1');
			}
			$infoQuery=$this->session->infoQuery;
			$infos=array();//置空总置顶
			$tmpinfos = $this->dao->select('*')->from(TABLE_INFO)->where($infoQuery)
			->andWhere('deleted')->eq(0)
			->orderBy('Stickie_desc,'.$orderBy)->page($pager)->fetchAll();
		}
		$infos=array_merge($infos,$tmpinfos);
		/* Process the sql, get the conditon partion, save it to session. Thus the report page can use the same condition. */
		$sql = explode('WHERE', $this->dao->get());
		$sql = explode('ORDER', $sql[1]);
		$sql = explode('AND Stickie', $sql[0]);
		//print $sql[0].'<br />';
		$this->session->set('infoReportCondition', $sql[0]);
		
		//*********************************************************************************************
		/* Build the search form. */
		$this->config->info->search['actionURL'] = $this->createLink('info', 'browse', "libID=$libID&moduleID=$moduleID&browseType=bySearch&queryID=myQueryID");
		$this->config->info->search['queryID']   = $queryID;
		$this->config->info->search['params']['lib']['values']     = array(''=>'') + $this->infolibs;

		/* Get the modules. */
		$moduleOptionMenu = $this->info->getOptionMenu($libID, 'info', $startModuleID = 0);
		$this->config->info->search['params']['module']['values']        = array(''=>'') + $moduleOptionMenu;
		$this->view->searchForm = $this->fetch('search', 'buildForm', $this->config->info->search);
		//*********************************************************************************************
		
		
		$users = $this->user->getPairs('noletter');
		if ($browseType == 'all') $this->view->header->title = $this->lang->info->index;
		else
			$this->view->header->title = $this->infolibs[$libID] . $this->lang->colon . $this->lang->info->index;
		$this->view->moduleTree  = $this->info->getTreeMenu($libID, $viewType = 'info', $startModuleID = 0, array('infoModel', 'createInfoLink'));
		$this->view->treeClass   = $browseType == 'bymodule' ? '' : 'hidden';
		$this->view->browseType  = $browseType;
		$this->view->moduleID    = $moduleID;
		$this->view->libID       = $libID;
		$this->view->infos       = $infos;
		$this->view->users       = $users;
		$this->view->pager       = $pager;
		$this->view->param       = $param;
		$this->view->orderBy     = $orderBy;
		$this->display();
	}
	public function create($libID, $moduleID = 0)
	{
		if (!$libID){
			echo js::alert($this->lang->info->noLib);
			die(js::locate($this->createLink('info', 'browse'), 'parent'));
		}
		if(!empty($_POST))
		{
			$infoID = $this->info->createInfo();
			if(dao::isError()) die(js::error(dao::getError()));
			$actionID = $this->action->create('info', $infoID, 'Created');

			$this->sendmail($infoID, $actionID);
			$vars = "libID=$libID&moduleID={$this->post->module}";
			$link = $this->createLink('info', 'browse', $vars);
			die(js::locate($link, 'parent'));
		}

		/* According the from, set menus. */
		$this->info->setMenu($this->infolibs, $libID);

		/* Get the modules. */
		$moduleOptionMenu = $this->info->getOptionMenu($libID, 'info', $startModuleID = 0);

		$this->view->header->title = $this->infolibs[$libID] . $this->lang->colon . $this->lang->info->create;
		$this->view->position[]    = html::a($this->createLink('info', 'browse', "libID=$libID"), $this->infolibs[$libID]);
		$this->view->position[]    = $this->lang->info->create;

		/* Init vars. */
		$mailto     = '';
		$this->view->users = $this->user->getPairs('nodeleted');
		$this->view->mailto           = $mailto;
		$this->view->libID            = $libID;
		$this->view->libs             = $this->info->getLibPairs($params = 'nodeleted');
		$this->view->moduleOptionMenu = $moduleOptionMenu;
		$this->view->moduleID         = $moduleID;

		$this->display();
	}
	public function edit($infoID)
	{
		if(!empty($_POST))
		{
			$changes  = $this->info->update($infoID);
			if(dao::isError()) die(js::error(dao::getError()));
			$files = $this->loadModel('file')->saveUpload('info', $infoID);
			if($this->post->comment != '' or !empty($changes) or !empty($files))
			{
				$action = !empty($changes) ? 'Edited' : 'Commented';
				$fileAction = '';
				if(!empty($files)) $fileAction = $this->lang->addFiles . join(',', $files) . "\n" ;
				$actionID = $this->action->create('info', $infoID, $action, $fileAction . $this->post->comment);
				$this->action->logHistory($actionID, $changes);
				$this->sendmail($infoID, $actionID);
			}
			die(js::locate($this->createLink('info', 'view', "infoID=$infoID"), 'parent'));
		}

		/* Get doc and set menu. */
		$info = $this->info->getInfoById($infoID);
		$libID = $info->lib;
		$this->info->setMenu($this->infolibs, $libID);

		/* Get modules. */
		$moduleOptionMenu = $this->info->getOptionMenu($libID, 'info', $startModuleID = 0);
		$this->view->users            = $this->user->appendDeleted($this->user->getPairs('nodeleted'), "$info->mailto");
		$this->view->header->title = $this->infolibs[$libID] . $this->lang->colon . $this->lang->info->edit;
		$this->view->position[]    = html::a($this->createLink('info', 'browse', "libID=$libID"), $this->infolibs[$libID]);
		$this->view->position[]    = $this->lang->info->edit;

		$this->view->info             = $info;
		$this->view->libID            = $libID;
		$this->view->libs             = $this->info->getLibPairs();
		$this->view->users            = $this->user->getPairs('noclosed,nodeleted');
		$this->view->moduleOptionMenu = $moduleOptionMenu;
		$this->display();
	}
	public function delete($infoID, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->info->confirmDelete, inlink('delete', "infoID=$infoID&confirm=yes")));
		}
		else
		{
			$this->info->delete(TABLE_INFO, $infoID);
			die(js::locate($this->session->infoList, 'parent'));
		}
	}
	public function view($infoID)
	{
		/* Judge bug exits or not. */
		$info = $this->info->getInfoById($infoID);
		if(!$info) die(js::error($this->lang->notFound) . js::locate('back'));

		/* Set menu. */
		$libID=$info->lib;
		$this->info->setMenu($this->infolibs, $libID, 'info');

		$libName = $this->infolibs[$libID];

		/* Header and positon. */
		$this->view->header->title = $this->infolibs[$libID] . $this->lang->colon . $this->lang->info->view;
		$this->view->position[]    = html::a($this->createLink('info', 'browse', "libID=$libID"), $libName);
		$this->view->position[]    = $this->lang->info->view;

		/* Assign. */
		$this->view->modulePath  = $this->info->getParents($info->module);
		$this->view->info         = $info;
		$this->view->libName = $libName;
		$this->view->users       = $this->user->getPairs('noletter');
		$this->view->actions     = $this->action->getList('info', $infoID);

		$this->display();
	}
	public function createLib()
	{
		if(!empty($_POST))
		{
			$libID = $this->info->createLib();
			if(!dao::isError())
			{
				$this->loadModel('action')->create('infoLib', $libID, 'Created');
				die(js::locate($this->createLink($this->moduleName, 'browse', "libID=$libID"), 'parent'));
			}
			else
			{
				echo js::error(dao::getError());
			}
		}
		die($this->display());
	}
	public function editLib($libID)
	{
		if(!empty($_POST))
		{
			$changes = $this->info->updateLib($libID); 
			if(dao::isError()) die(js::error(dao::getError()));
			if($changes)
			{
				$actionID = $this->loadModel('action')->create('infoLib', $libID, 'edited');
				$this->action->logHistory($actionID, $changes);
			}
			die(js::locate($this->createLink($this->moduleName, 'browse', "libID=$libID"), 'parent'));
		}
		if($libID=='default')
		{
			$libID=$this->info->getDefaultLibId();
		}
		$lib = $this->info->getLibByID($libID);
		$this->view->libName = empty($lib) ? $libID : $lib->name;
		$this->view->libID   = $libID;
		$this->view->defaultLib   = $lib->defaultlib;
		
		die($this->display());
	}
	public function deleteLib($libID, $confirm = 'no')
	{
		if($libID=='default')
		{
			$libID=$this->info->getDefaultLibId();
		}
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->info->confirmDeleteLib, $this->createLink('info', 'deleteLib', "libID=$libID&confirm=yes")));
		}
		else
		{
			$this->info->delete(TABLE_INFOLIB, $libID);
			die(js::locate($this->createLink('info', 'browse'), 'parent'));
		}
	}
	public function TreeManage($rootID, $currentModuleID = 0)
	{
		$viewType='info';
		$lib = $this->loadModel('info')->getLibById($rootID);
		$this->view->root = $lib;
		$this->info->setMenu($this->info->getInfoLibs(), $rootID, 'info');
		$this->lang->set('menugroup.info', 'info');

		$header['title'] = $this->lang->info->manageCustomInfo . $this->lang->colon . $lib->name;
		$position[]      = html::a($this->createLink('info', 'browse', "libID=$rootID"), $lib->name);
		$position[]      = $this->lang->info->manageCustomInfo;
		
		$parentModules = $this->info->getParents($currentModuleID);
		$this->view->header          = $header;
		$this->view->position        = $position;
		$this->view->rootID          = $rootID;
		$this->view->viewType        = $viewType;
		$this->view->modules         = $this->info->getTreeMenu($rootID, $viewType, $rooteModuleID = 0, array('infoModel', 'createManageLink'));
		$this->view->sons            = $this->info->getSons($rootID, $currentModuleID, $viewType);
		$this->view->currentModuleID = $currentModuleID;
		$this->view->parentModules   = $parentModules;
		$this->display();
	}
	public function TreeEdit($moduleID)
	{
		if(!empty($_POST))
		{
			$this->info->updateTree($moduleID);
			echo js::alert($this->lang->tree->successSave);
			die(js::reload('parent'));
		}
		$module = $this->info->getModuleById($moduleID);
		if($module->owner == null)
		{
		   //$module->owner = $this->loadModel('product')->getById($module->root)->QM;
		}
		$this->view->module     = $module;
		$this->view->optionMenu = $this->info->getOptionMenu($this->view->module->root);
		$this->view->users      = $this->loadModel('user')->getPairs('noclosed');

		/* Remove self and childs from the $optionMenu. Because it's parent can't be self or childs. */
		$childs = $this->info->getAllChildId($moduleID);
		foreach($childs as $childModuleID) unset($this->view->optionMenu[$childModuleID]);

		die($this->display());
	}
	public function TreeDelete($rootID, $moduleID, $confirm = 'no')
	{
		if($confirm == 'no')
		{
			echo js::confirm($this->lang->tree->confirmDelete, $this->createLink('info', 'TreeDelete', "rootID=$rootID&moduleID=$moduleID&confirm=yes"));
			exit;
		}
		else
		{
			$this->info->deleteModule($moduleID);
			die(js::reload('parent'));
		}
	}
	public function TreeManageChild($rootID)
	{
		if(!empty($_POST))
		{
			$this->info->manageChild($rootID, $_POST['parentModuleID'], $_POST['modules']);
			die(js::reload('parent'));
		}
	}
	public function TreeUpdateOrder()
	{
		if(!empty($_POST))
		{
			$this->info->updateOrder($_POST['orders']);
			die(js::reload('parent'));
		}
	}
	public function TreeAjaxGetOptionMenu($rootID, $viewType = 'info', $rootModuleID = 0, $returnType = 'html')
	{
		$this->view->productModules = $this->info->getOptionMenu($rootID, 'info');
		$optionMenu = $this->info->getOptionMenu($rootID, $viewType, $rootModuleID);
		if($returnType == 'html') die( html::select("module", $optionMenu, '', 'onchange=setAssignedTo()'));
		if($returnType == 'json') die(json_encode($optionMenu));
	}
	public function upgrade()
	{
		$this->view->header->title = $this->lang->info->upgradeCommon . $this->lang->colon . $this->lang->info->upgradeSelectVersion;
		$this->view->position[]    = $this->lang->info->upgradeCommon;
		$this->display();
	}
	public function execute()
	{
		$this->info->execute($this->post->fromVersion);

		$this->view->header->title = $this->lang->info->upgradeResult;
		$this->view->position[]    = $this->lang->info->upgradeCommon;

		if(!$this->info->isError())
		{
			$this->view->result = 'Success';
			$this->info->setVersion();
		}
		else
		{
			$this->view->result = 'Fail';
			$this->view->errors = $this->info->getError();
		}
		$this->display();
	}
	private function sendmail($infoID, $actionID)
	{
		/* Set toList and ccList. */
		$info         = $this->info->getInfoById($infoID);
		$libName = $this->infolibs[$info->lib];
		$modulePath  = $this->info->getParents($info->module);
		$moduleName='';
		foreach($modulePath as $key => $module){
			$moduleName .= $module->name;
			if(isset($modulePath[$key + 1])) $moduleName .= '-';
		}
		$toList      = '';
		$ccList      = trim($info->mailto, ',');
		if($toList == '')
		{
			if($ccList == '') return;
			if(strpos($ccList, ',') === false)
			{
				$toList = $ccList;
				$ccList = '';
			}
			else
			{
				$commaPos = strpos($ccList, ',');
				$toList = substr($ccList, 0, $commaPos);
				$ccList = substr($ccList, $commaPos + 1);
			}
		}

		/* Get action info. */
		$action          = $this->action->getById($actionID);
		$history         = $this->action->getHistory($actionID);
		$action->history = isset($history[$actionID]) ? $history[$actionID] : array();
		if(strtolower($action->action) == 'Created') $action->comment = $info->content;

		/* Create the mail content. */
		$this->view->info    = $info;
		$this->view->action = $action;
		$mailContent = $this->parse($this->moduleName, 'sendmail');

		/* Send it. */
		$this->loadModel('mail')->send($toList, $libName . ':'.$moduleName . ':' . 'INFO #'. $info->id . $this->lang->colon . $info->title, $mailContent, $ccList);
		if($this->mail->isError()) echo js::error($this->mail->getError());
	}
	public function export($productID, $orderBy)
	{
		if($_POST)
		{
			$infoLang   = $this->lang->info;
			$infoConfig = $this->config->info;

			/* Create field lists. */
			$fields = explode(',', $infoConfig->list->exportFields);
			foreach($fields as $key => $fieldName)
			{
				$fieldName = trim($fieldName);
				$fields[$fieldName] = isset($infoLang->$fieldName) ? $infoLang->$fieldName : $fieldName;
				unset($fields[$key]);
			}

			/* Get infos. */
			$infos = $this->dao->select('*')->from(TABLE_INFO)->alias('t1')->where($this->session->infoReportCondition)->orderBy($orderBy)->fetchAll('id');
			
			/* Get users, products and projects. */
			$users    = $this->loadModel('user')->getPairs('noletter');
			$libs = $this->info->getLibPairs();

			/* Get related objects id lists. */
			$relatedModuleIdList = array();

			foreach($infos as $info)
			{
				$relatedModuleIdList[$info->module]    = $info->module;
			}

			/* Get related objects title or names. */
			$relatedModules = $this->dao->select('id, name')->from(TABLE_INFOMODULE)->where('id')->in($relatedModuleIdList)->fetchPairs();
			$relatedFiles   = $this->dao->select('id, objectID, pathname, title')->from(TABLE_FILE)->where('objectType')->eq('info')->andWhere('objectID')->in(@array_keys($infos))->fetchGroup('objectID');

			foreach($infos as $info)
			{
				if($this->post->fileType == 'csv')
				{
					$info->content = htmlspecialchars_decode($info->content);
//                    $info->content = str_replace("<br />", "\n", $info->content);
					$info->content = str_replace('"', '""', $info->content);
				}

				/* fill some field with useful value. */
				if(isset($libs[$info->lib]))         $info->lib      = $libs[$info->lib];
				if(isset($relatedModules[$info->module]))    $info->module       = $relatedModules[$info->module];

				if(isset($infoLang->priList[$info->pri]))               $info->pri        = $infoLang->priList[$info->pri];
				if(isset($users[$info->createdBy]))     $info->createdBy     = $users[$info->createdBy];
				if(isset($users[$info->lastEditedBy])) $info->lastEditedBy = $users[$info->lastEditedBy];

				$info->createdDate     = substr($info->createdDate,     0, 10);
				$info->lastEditedDate = substr($info->lastEditedDate, 0, 10);

				/* Set related files. */
				if(isset($relatedFiles[$info->id]))
				{
					foreach($relatedFiles[$info->id] as $file)
					{
						$fileURL = 'http://' . $this->server->http_host . $this->config->webRoot . "data/upload/$info->company/" . $file->pathname;
						$info->files .= html::a($fileURL, $file->title, '_blank') . '<br />';
					}
				}

				$info->mailto = trim(trim($info->mailto), ',');
				$mailtos      = explode(',', $info->mailto);
				$info->mailto = '';
				foreach($mailtos as $mailto)
				{
					$mailto = trim($mailto);
					if(isset($users[$mailto])) $info->mailto .= $users[$mailto] . ',';
				}

				/* drop some field that is not needed. */
				unset($info->company);
				unset($info->deleted);
			}

			$this->post->set('fields', $fields);
			$this->post->set('rows', $infos);
			$this->fetch('file', 'export2' . $this->post->fileType, $_POST);
		}

		$this->display();
	}
	public function HighlightAndStickie()
	{
		$this->locate($this->createLink('info', 'browse'));
	}
}
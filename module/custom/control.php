<?php
class custom extends control {
	public function __construct() {
		parent::__construct();
		$this->loadModel('info');
	}
	public function index() {
		$this->locate($this->createLink('custom', 'browse'));
	}
	public function browse($type = 'info') {
		//$this->custom->setMenu();
		$header['title'] = $this->lang->custom->{$type.'Custom'};
		$position[] = $this->lang->custom->{$type.'Custom'};
		
		$table = $this->config->custom->typeToTable[$type];
		$customs=$this->app->dbh->query("SHOW FULL COLUMNS FROM  `".$table."` like 'custom_%'")->fetchAll(PDO::FETCH_OBJ);
		//var_dump($customs);
		foreach($customs as $custom) {
			$custom->Field = substr($custom->Field,strlen($this->config->customFieldPrefix));
		}
		$this->view->header          = $header;
		$this->view->position        = $position;
		$this->view->customs         = $customs;
		$this->view->type            = $type;
		$this->display();
	}
	public function create($moduleType = 'info',$extras = '') {
		
		if(!empty($_POST))
		{
			$custom = $this->custom->gererateCustomField($moduleType);
			//if(dao::isError()) die(js::error(dao::getError()));

			$vars = "type=$moduleType";
			$link = $this->createLink('custom', 'browse', $vars);
			die(js::locate($link, 'parent'));
		}
		
		/* Init vars. */
		$Field='';
		$Type='VARCHAR';
		$Length='255';
		$DefaultType='USER_DEFINED';
		$DefaultValue = '';
		$Null='';
		$Comment='';
		
		/* Parse the extras. */
		$extras = str_replace(array(',', ' '), array('&', ''), $extras);
		parse_str($extras);
		
		if(isset($customName)) {
			//$custom = $this->custom->getcustomByName($customName);
			//extract((array)$custom);
			
			/* get Type and Length from $custom->Type */
			// code
		}
		
		$this->view->oldField = '';
		$this->view->Field = $Field;
		$this->view->Type = $Type;
		$this->view->Length = $Length;
		$this->view->DefaultType = $DefaultType;
		$this->view->DefaultValue = $DefaultValue;
		$this->view->Null = $Null;
		$this->view->Comment = $Comment;
		$this->view->moduleType = $moduleType;
		$this->view->actionType = 'create';
		$this->display();
	}
	public function edit($moduleType = 'info',$field) {
		if(!empty($_POST))
		{
			$custom = $this->custom->gererateCustomField($moduleType,'change');

			$vars = "type=$moduleType";
			$link = $this->createLink('custom', 'browse', $vars);
			die(js::locate($link, 'parent'));
		}
		
		$table = $this->config->custom->typeToTable[$moduleType];
		$custom=$this->app->dbh->query("SHOW FULL COLUMNS FROM  `".$table."` WHERE `Field` = '".$this->config->customFieldPrefix.$field."'")->fetch(PDO::FETCH_OBJ);
		
		/* Init vars. */
		$custom->Field = substr($custom->Field,strlen($this->config->customFieldPrefix));
		if (strpos($custom->Type,'(')!==false) {
			$custom->Length= substr($custom->Type,strpos($custom->Type,'(')+1,strpos($custom->Type,')')-strpos($custom->Type,'(')-1);
			$custom->Length = str_replace( "'", "&#39;",$custom->Length);
		}else{
			$custom->Length = 0;
		}
		$custom->Type = strtoupper(substr($custom->Type,0,strpos($custom->Type,'(')));
		$custom->Null = ($custom->Null == 'NO')?'':'NULL';
		if (empty($custom->Default) && $custom->Default != '0') {
			$DefaultType = 'NONE';
			$DefaultValue= '';
		}
		else {
			$DefaultType = 'USER_DEFINED';
			$DefaultValue= isset($custom->Default) ? $custom->Default : '';
		}
		$custom->Comment = str_replace( "\"", "&#34;",$custom->Comment);
		$custom->Comment = str_replace( "'", "&#39;",$custom->Comment);
		//var_dump($custom);
		
		extract((array)$custom);
		$this->view->oldField = $Field;
		$this->view->Field = $Field;
		$this->view->Type = $Type;
		$this->view->Length = $Length;
		$this->view->DefaultType = $DefaultType;
		$this->view->DefaultValue = $DefaultValue;
		$this->view->Null = $Null;
		$this->view->Comment = $Comment;
		$this->view->moduleType = $moduleType;
		$this->view->actionType = 'edit';
		$this->display();
	}
	public function delete($moduleType = 'info',$field,$confirm = 'no') {
		if($confirm == 'no')
		{
			die(js::confirm($this->lang->custom->confirmDelete, inlink('delete', "moduleType=$moduleType&field=$field&confirm=yes")));
		}
		else
		{
			$this->custom->delete($moduleType, $field);
			$vars = "type=$moduleType";
			$link = $this->createLink('custom', 'browse', $vars);
			die(js::locate($link, 'parent'));
		}
	}
}
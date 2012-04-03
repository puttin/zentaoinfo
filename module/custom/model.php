<?php
class customModel extends model {
	public function setMenu($type = 'info')
	{
		foreach($this->lang->custom->menu as $key => $menu)
		{
			//common::setMenuVars($this->lang->custom->menu, $key, $type);
		}
	}
	public function gererateCustomField($type = 'info',$method = 'add') {
		$this->app->loadClass('infoextdao',$static = true);
		//echo $_REQUEST['Null'][0]."\n";
		$oldField = '';
		if (empty($_REQUEST['Field']) && $_REQUEST['Field'] != '0') {
			echo js::alert($this->lang->custom->fieldEmpty);
			return false;
		}
		if (!(empty($_REQUEST['oldField']) && $_REQUEST['oldField'] != '0')) {
			$oldField = $_REQUEST['oldField'];
			$oldField = infoextdao::backquote($this->config->customFieldPrefix.$oldField);
			//echo js::alert($oldField);
		}
		$custom = fixer::input('post')
				->setDefault('Collation', 'utf8_general_ci')
				->setDefault('Attribute', '')
				->setDefault('Extra', false)
				->get();
		$field_primary  = array();
		//var_dump($custom);
		
		$definition = ' '.strtoupper($method).' '.$oldField.' ' . infoextdao::generateFieldSpec(
			$this->config->customFieldPrefix.$custom->Field,
			$custom->Type,
			$custom->Length,
			$custom->Attribute,
			$custom->Collation,
			isset($_REQUEST['NULL'][0])
				? $_REQUEST['NULL'][0]
				: 'NOT NULL',
			$custom->DefaultType,
			$custom->DefaultValue,
			$custom->Extra,
			$custom->Comment,
			$field_primary,
			0
		);
		$table = $this->config->custom->typeToTable[$type];
		$sql_query = 'ALTER TABLE ' . infoextdao::backquote($table) . ' ' . $definition;
		//echo js::alert($sql_query);
		try {
			$result = $this->app->dbh->query($sql_query);
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo js::alert(addslashes($sql_query));
			echo js::alert($this->lang->custom->alterTableFailed);
			return false;
		}
		return true;
	}
	public function delete($type,$field) {
		$this->app->loadClass('infoextdao',$static = true);
		$table = $this->config->custom->typeToTable[$type];
		$sql_query = 'ALTER TABLE ' . infoextdao::backquote($table) . ' ' . "DROP COLUMN ".infoextdao::backquote($this->config->customFieldPrefix.$field);
		try {
			$result = $this->app->dbh->query($sql_query);
		}
		catch(Exception $e) {
			//echo 'Message: ' .$e->getMessage();
			echo js::alert(addslashes($sql_query));
			echo js::alert($this->lang->custom->alterTableFailed);
			return false;
		}
	}
	public function dealWithCustomArrayField() {
		$skipFields = '';
		foreach($_POST as $key => $post){
			if (is_array($post) && strpos($key,$this->config->customFieldPrefix)!==false) {
				$_POST[$key]=implode(',',$post);
				//echo js::alert($key.$post);
				$skipFields .= $key.',';
				//echo js::alert($skipFields);
			}
		}
		return $skipFields;
	}
}
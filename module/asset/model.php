<?php
class assetModel extends model{
	public function getAssets($libID, $module, $orderBy, $pager)
	{
		return $this->dao->select('*')->from(TABLE_INFOASSET)
			->where('deleted')->eq(0)
			->beginIF(is_numeric($libID))->andWhere('lib')->eq($libID)->fi()
			->beginIF($module)->andWhere('module')->in($module)->fi()
			->orderBy($orderBy)
			->page($pager)
			->fetchAll();
	}
	public function getAssetById($assetID)
	{
		$asset = $this->dao->select('*')
			->from(TABLE_INFOASSET)
			->where('id')->eq((int)$assetID)->fetch();
		if(!$asset) return false;
		foreach($asset as $key => $value) if(strpos($key, 'Date') !== false and !(int)substr($value, 0, 4)) $asset->$key = '';
        return $asset;
	}
	public function createAsset()
	{
		$now = helper::now();
		$today = helper::today();
		$address=fixer::input('post')->get('address');
		$extendaddress=fixer::input('post')->get('extendaddress');
		$devicenumber=fixer::input('post')->get('devicenumber');
		$code=fixer::input('post')->get('code');
		$module = $this->loadModel('info')->getAllChildId(fixer::input('post')->cleanInt('module')->setDefault('module', 0)->get('module'),'asset');
		$result1 = $this->dao->select('*')->from(TABLE_INFOASSET)
				->where('address')->eq($extendaddress)
				->andWhere('address')->ne('IP Format Error')
				->andWhere('address')->ne('Conflict!')
				->andWhere('address')->ne('')
				->beginIF($module)->andWhere('module')->in($module)->fi()
				->fetchAll();
		$result2 = $this->dao->select('*')->from(TABLE_INFOASSET)
				->where('extendaddress')->eq($address)
				->andWhere('extendaddress')->ne('IP Format Error')
				->andWhere('extendaddress')->ne('Conflict!')
				->andWhere('extendaddress')->ne('')
				->beginIF($module)->andWhere('module')->in($module)->fi()
				->fetchAll();
		$asset = fixer::input('post')
			->cleanInt('module')
			->setDefault('module', 0)
			->add('createdBy', $this->app->user->account)
			->add('createdDate', $now)
			->add('lastEditedDate', $now)
			->add('registdate', $today)
			->setDefault('module', 0)
			->setDefault('lenddate', '0000-00-00')
			->setDefault('returndate', '0000-00-00')
			->setIF(!(strlen(trim($extendaddress))==0) && !validater::checkIP($extendaddress),'extendaddress','IP Format Error')
			->setIF(!(strlen(trim($address))==0) && !validater::checkIP($address),'address','IP Format Error')
			->removeIF(trim($address)==trim($extendaddress),'extendaddress')
			->setIF($result1,'extendaddress','Conflict!')
			->setIF($result2,'address','Conflict!')
			->get();
		$condition = "module = '$asset->module'";
		$conditionaddress = $condition." and address != 'IP Format Error' and address != 'Conflict!'";
		$conditionextaddress = $condition." and extendaddress != 'IP Format Error' and extendaddress != 'Conflict!'";
		$this->dao->insert(TABLE_INFOASSET)
			->data($asset)
			->autoCheck()
			->batchCheck($this->config->asset->create->requiredFields, 'notempty')
			->check('hostname', 'unique', $condition)
			->checkIF(!(strlen(trim($address))==0),'address', 'unique', $conditionaddress)
			->checkIF(!(strlen(trim($extendaddress))==0),'extendaddress', 'unique', $conditionextaddress)
			->checkIF(!(strlen(trim($devicenumber))==0),'devicenumber', 'unique', $condition)
			->checkIF(!(strlen(trim($code))==0),'code', 'unique', $condition)
			->exec();
		if(!dao::isError())
		{
			$assetID = $this->dao->lastInsertID();
			return $assetID;
		}
		return false;
	}
	public function createAssetLink($module)
	{
		$linkHtml = html::a(helper::createLink('asset', 'browse', "libID={$module->root}&&moduleID={$module->id}"), $module->name, '_self', "id='module{$module->id}'");
		return $linkHtml;
	}
	public function update($assetID){
		$oldAsset = $this->getAssetById($assetID);
		$now = helper::now();
		$address=fixer::input('post')->get('address');
		$extendaddress=fixer::input('post')->get('extendaddress');
		$devicenumber=fixer::input('post')->get('devicenumber');
		$code=fixer::input('post')->get('code');
		$module = $this->loadModel('info')->getAllChildId(fixer::input('post')->cleanInt('module')->setDefault('module', 0)->get('module'),'asset');
		$result1 = $this->dao->select('*')->from(TABLE_INFOASSET)
				->where('address')->eq($extendaddress)
				->andWhere('address')->ne('IP Format Error')
				->andWhere('address')->ne('Conflict!')
				->andWhere('address')->ne('')
				->beginIF($module)->andWhere('module')->in($module)->fi()
				->fetchAll();
		$result2 = $this->dao->select('*')->from(TABLE_INFOASSET)
				->where('extendaddress')->eq($address)
				->andWhere('extendaddress')->ne('IP Format Error')
				->andWhere('extendaddress')->ne('Conflict!')
				->andWhere('extendaddress')->ne('')
				->beginIF($module)->andWhere('module')->in($module)->fi()
				->fetchAll();
		$asset = fixer::input('post')
			->cleanInt('module')
			->setDefault('module', 0)
			->add('lastEditedBy',$this->app->user->account)
			->add('lastEditedDate',$now)
			->setDefault('lenddate', '0000-00-00')
			->setDefault('returndate', '0000-00-00')
			->setIF(!(strlen(trim($extendaddress))==0) && !validater::checkIP($extendaddress),'extendaddress','IP Format Error')
			->setIF(!(strlen(trim($address))==0) && !validater::checkIP($address),'address','IP Format Error')
			->removeIF(trim($address)==trim($extendaddress),'extendaddress')
			->setIF($result1,'extendaddress','Conflict!')
			->setIF($result2,'address','Conflict!')
			->get();
		$condition = "module = '$asset->module' and id != '$assetID'";
		$conditionaddress = $condition." and address != 'IP Format Error' and address != 'Conflict!'";
		$conditionextaddress = $condition." and extendaddress != 'IP Format Error' and extendaddress != 'Conflict!'";
		$this->dao->update(TABLE_INFOASSET)->data($asset)
			->autoCheck()
			->batchCheck($this->config->asset->edit->requiredFields, 'notempty')
			->check('hostname', 'unique', $condition)
			->checkIF(!(strlen(trim($address))==0),'address', 'unique', $conditionaddress)
			->checkIF(!(strlen(trim($extendaddress))==0),'extendaddress', 'unique', $conditionextaddress)
			->checkIF(!(strlen(trim($devicenumber))==0),'devicenumber', 'unique', $condition)
			->checkIF(!(strlen(trim($code))==0),'code', 'unique', $condition)
			->where('id')->eq((int)$assetID)
			->exec();
		$asset->editedCount=$asset->editedCount-1;
		if(!dao::isError()) return common::createChanges($oldAsset, $asset);
	}
}
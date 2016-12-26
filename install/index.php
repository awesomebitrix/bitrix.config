<?php

Bitrix\Main\Localization\Loc::loadLanguageFile(__FILE__);

Class wlbl_config extends CModule
{
	public $MODULE_ID = "wlbl.config";
	public $MODULE_VERSION;
	public $MODULE_VERSION_DATE;
	public $MODULE_NAME;
	public $MODULE_DESCRIPTION;
	public $MODULE_CSS;
	public $MODULE_GROUP_RIGHTS = "Y";

	public function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path . "/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

		$this->MODULE_NAME = GetMessage("WLBL_CONFIG_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("WLBL_CONFIG_MODULE_DESC");
		$this->PARTNER_NAME = GetMessage("WLBL_CONFIG_MODULE_PARTNER");
		$this->PARTNER_URI = GetMessage("WLBL_CONFIG_MODULE_URI");
	}

	public function InstallDB()
	{
		RegisterModule($this->MODULE_ID);
		if (\Bitrix\Main\Loader::includeModule($this->MODULE_ID)) {
			try {
				Wlbl\Config\Table\ConfigTable::getEntity()->createDbTable();
			} catch (\Bitrix\Main\DB\SqlException $e) {
			}
		}

		return true;
	}

	public function UnInstallDB()
	{
		if (\Bitrix\Main\Loader::includeModule($this->MODULE_ID)) {
			\Bitrix\Main\Application::getConnection()->query(
				'DROP TABLE IF EXISTS ' . \Wlbl\Config\Table\ConfigTable::getTableName()
			);
		}

		UnRegisterModule($this->MODULE_ID);

		return true;
	}

	public function InstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->registerEventHandler(
			'main',
			'OnPageStart',
			$this->MODULE_ID,
			'\Wlbl\Config\EventHandlers',
			'onPageStart'
		);

		return true;
	}

	public function UnInstallEvents()
	{
		$eventManager = \Bitrix\Main\EventManager::getInstance();

		$eventManager->unRegisterEventHandler(
			'main',
			'OnPageStart',
			$this->MODULE_ID,
			'\Wlbl\Config\EventHandlers',
			'onPageStart'
		);

		return true;
	}

	public function InstallFiles()
	{
		return true;
	}

	public function UnInstallFiles()
	{
		return true;
	}

	public function DoInstall()
	{
		if (!IsModuleInstalled($this->MODULE_ID)) {
			$this->InstallDB();
			$this->InstallEvents();
			$this->InstallFiles();
		}
	}

	public function DoUninstall()
	{
		$this->UnInstallDB();
		$this->UnInstallEvents();
		$this->UnInstallFiles();
	}
}
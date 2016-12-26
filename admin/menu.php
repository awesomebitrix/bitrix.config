<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Wlbl\Config\Table\AdminInterface\ConfigEditHelper;
use Wlbl\Config\Table\AdminInterface\ConfigListHelper;

if (!Loader::includeModule('digitalwand.admin_helper') || !Loader::includeModule('wlbl.config')) {
	return;
}

Loc::loadMessages(__FILE__);

$menu = [
	'parent_menu' => 'global_menu_settings',
	'sort' => 100,
	'items_id' => 'wlbl_config_menu',
	'icon' => 'sys_menu_icon',
	'page_icon' => 'sys_menu_icon',
	'text' => 'Общие настройки сайта',
	'url' => ConfigListHelper::getUrl(),
	'more_url' => [
		ConfigEditHelper::getUrl(),
	],

];

return $menu;

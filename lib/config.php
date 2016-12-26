<?php

namespace Wlbl\Config;

use Wlbl\Config\Table\ConfigTable;

class Config
{
	private static $config;

	public static function get($code = null)
	{
		if (empty($code)) {
			return null;
		}

		if (!isset(self::$config)) {
			self::load();
		}

		return (isset(self::$config[$code]) ? self::$config[$code] : null);
	}

	private static function load()
	{
		$config = [];
		$dbData = ConfigTable::getList([
			'select' => ['code', 'value'],
		]);

		while ($row = $dbData->fetch()) {
			$config[$row['code']] = $row['value'];
		}

		static::$config = $config;
	}
}

<?php
namespace Wlbl\Config\Table;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Event;

class ConfigTable extends DataManager
{
	public static function getTableName()
	{
		return 'wlbl_config';
	}

	public static function getMap()
	{
		return [
			new Entity\IntegerField(
				'ID',
				[
					'column_name' => 'id',
					'primary' => true,
					'autocomplete' => true,
					'title' => 'ID',
				]
			),
			new Entity\StringField(
				'code',
				[
					'required' => true,
					'title' => 'Символьный код',
					'validation' => function () {
						return [
							new Entity\Validator\Unique(),
						];
					},
				]
			),
			new Entity\StringField(
				'value',
				[
					'required' => true,
					'title' => 'Значение',
				]
			),
			new Entity\BooleanField(
				'is_system',
				[
					'title' => 'Системное',
				]
			),
		];
	}

	public static function onBeforeDelete(Event $event)
	{
		$result = new Entity\EventResult();

		$primary = $event->getParameter('primary');

		$isSystem = self::getRow([
			'filter' => $primary,
			'select' => ['is_system']
		]);

		if (boolval($isSystem['is_system'])) {
			$result->addError(new Entity\EntityError('Нелья удалить системное свойство!'));
		}

		return $result;
	}
}

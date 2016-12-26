<?php
/**
 * Created by PhpStorm.
 * User: dmnbars
 * Date: 26/12/16
 * Time: 18:04
 */

namespace Wlbl\Config\Table\AdminInterface;

use DigitalWand\AdminHelper\Helper\AdminInterface;
use DigitalWand\AdminHelper\Widget\CheckboxWidget;
use DigitalWand\AdminHelper\Widget\NumberWidget;
use DigitalWand\AdminHelper\Widget\StringWidget;

/**
 * {@inheritdoc}
 */
class ConfigAdminInterface extends AdminInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function fields()
	{
		return [
			'MAIN' => [
				'NAME' => 'Общие настройки сайта',
				'FIELDS' => [
					'ID' => [
						'WIDGET' => new NumberWidget(),
						'READONLY' => true,
						'FILTER' => true,
						'HIDE_WHEN_CREATE' => true,
						'EDIT_LINK' => true,
					],
					'code' => [
						'WIDGET' => new StringWidget(),
						'REQUIRED' => true,
					],
					'value' => [
						'WIDGET' => new StringWidget(),
						'REQUIRED' => true,
					],
					'is_system' => [
						'WIDGET' => new CheckboxWidget(),
					],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function helpers()
	{
		return [
			'Wlbl\Config\Table\AdminInterface\ConfigListHelper',
			'Wlbl\Config\Table\AdminInterface\ConfigEditHelper',
		];
	}
}

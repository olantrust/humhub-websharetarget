<?php

use olan\websharetarget\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\widgets\TopMenu;

return [
	'id' => 'websharetarget',
	'class' => 'olan\websharetarget\Module',
	'namespace' => 'olan\websharetarget',
	'events' => [
		[
			'class' => TopMenu::class,
			'event' => TopMenu::EVENT_INIT,
			'callback' => [Events::class, 'onTopMenuInit'],
		],
		[
			'class' => AdminMenu::class,
			'event' => AdminMenu::EVENT_INIT,
			'callback' => [Events::class, 'onAdminMenuInit']
		],
	],
];

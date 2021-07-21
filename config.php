<?php

use olan\websharetarget\Events;
use humhub\modules\admin\widgets\AdminMenu;

return [
	'id' => 'websharetarget',
	'class' => 'olan\websharetarget\Module',
	'namespace' => 'olan\websharetarget',
	'events' => [
		['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => [Events::class, 'onAdminMenuInit']],
	],
];

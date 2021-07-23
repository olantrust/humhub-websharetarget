<?php

use olan\websharetarget\Events;
use humhub\modules\admin\widgets\AdminMenu;
use humhub\modules\admin\widgets\SettingsMenu;
use humhub\components\Controller;

return [
	'id' => 'websharetarget',
	'class' => 'olan\websharetarget\Module',
	'namespace' => 'olan\websharetarget',
	'events' => [
		['class' => AdminMenu::class, 'event' => AdminMenu::EVENT_INIT, 'callback' => [Events::class, 'onAdminMenuInit']],
		['class' => SettingsMenu::class, 'event' => SettingsMenu::EVENT_INIT, 'callback' => [Events::class, 'onSettingsMenuInit']],
		['humhub\modules\web\pwa\controllers\ManifestController', Controller::EVENT_AFTER_ACTION, [Events::class, 'onManifestControllerInit']]
	],
];

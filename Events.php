<?php

namespace  olan\websharetarget;

use Yii;
use yii\helpers\Url;

/**
 * Event class for Web Share Target Module
 */
class Events
{
    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Web Share Target',
            'url' => Url::to(['/websharetarget/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-share-alt"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'websharetarget' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }
}

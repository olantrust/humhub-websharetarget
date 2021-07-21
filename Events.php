<?php

namespace  olan\websharetarget;

use Yii;
use yii\helpers\Url;

class Events
{
    /**
     * Defines what to do when the top menu is initialized.
     *
     * @param $event
     */
    public static function onTopMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Websharetarget',
            'icon' => '<i class="fa fa-share-alt"></i>',
            'url' => Url::to(['/websharetarget/index']),
            'sortOrder' => 99999,
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'websharetarget' && Yii::$app->controller->id == 'index'),
        ]);
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Websharetarget',
            'url' => Url::to(['/websharetarget/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-share-alt"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'websharetarget' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }
}

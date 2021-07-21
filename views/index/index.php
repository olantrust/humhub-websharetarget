<?php

use humhub\widgets\Button;

// Register our module assets, this could also be done within the controller
\olan\websharetarget\assets\Assets::register($this);

$displayName = (Yii::$app->user->isGuest) ? Yii::t('WebsharetargetModule.base', 'Guest') : Yii::$app->user->getIdentity()->displayName;

// Add some configuration to our js module
$this->registerJsConfig("websharetarget", [
    'username' => (Yii::$app->user->isGuest) ? $displayName : Yii::$app->user->getIdentity()->username,
    'text' => [
        'hello' => Yii::t('WebsharetargetModule.base', 'Hi there {name}!', ["name" => $displayName])
    ]
])

?>

<div class="panel-heading"><strong>Websharetarget</strong> <?= Yii::t('WebsharetargetModule.base', 'overview') ?></div>

<div class="panel-body">
    <p><?= Yii::t('WebsharetargetModule.base', 'Hello World!') ?></p>

    <?=  Button::primary(Yii::t('WebsharetargetModule.base', 'Say Hello!'))->action("websharetarget.hello")->loader(false); ?></div>

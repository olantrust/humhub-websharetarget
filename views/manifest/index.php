<?php

use humhub\widgets\Button;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCss('textarea {height:450px !important}')
?>
<div class="panel-body">
    <h4><strong>Manifest</strong> <?= Yii::t('WebsharetargetModule.base', 'configuration') ?></h4>
    <div class="help-block">Upon saving, this will overwrite the manifest.json to latest version.</div>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 20])->label(false); ?>

        <div class="form-group">
            <?= Button::save()->submit(); ?>
            <?= Html::a('Show Demo Content <i class="fa fa-angle-down"></i>', 'javascript:void(0)', ['class' => 'btn btn-info pull-right', 'onclick' => 'expane_collapse(this, "show_hide_demo")']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

<div id="show_hide_demo" class="panel-body" style="display:none">
<pre>{
  "gcm_sender_id": "103953800507",
  "iarc_rating_id": "f2ceb014-7d68-4953-8e0a-afa454eb8357",
  "name": "olan.net",
  "categories": ["communication", "business", "social", "messaging", "sharing", "collaboration", "news", "finances"],
  "dir": "ltr",
  "lang": "en-gb",
  "scope": "http://localhost/humhub/olan.net/",
  "display": "standalone",
  "start_url": "http://localhost/humhub/olan.net/?source=pwa",
  "short_name": "olan",
  "description": "Sharing, collaborating and workflow service community for Olan members, supporters and groups",
  "orientation": "portrait",
  "related_applications": [
    {
      "platform": "webapp",
      "url": "http://localhost/humhub/olan.net/manifest.json"
    },
    {
      "platform": "play",
      "url": "http://play.google.com/store/apps/details?id=net.olan.pwa",
      "id": "net.olan.pwa"
    },
    {
        "platform": "Windows App Store",
        "url": "http://www.microsoft.com/store/apps/9P388QPP1RTB"
    }
  ],
  "prefer_related_applications": true,
  "background_color": "#48596d",
  "theme_color": "#3367D6",
  "icons": [
    {
      "src": "http://localhost/humhub/olan.net/olan-net-icon-192.png",
      "sizes": "192x192",
      "type": "image/png",
      "purpose": "any maskable"
    },
    {
      "src": "http://localhost/humhub/olan.net/olan-net-icon-512.png",
      "type": "image/png",
      "sizes": "512x512",
      "purpose": "any maskable"
    }
  ],
  "shortcuts": [
    {
      "name": "Messages",
      "short_name": "Messages",
      "description": "olan.net messaging app",
      "url": "http://localhost/humhub/olan.net/mail/mail/index?source=pwa",
      "icons": [
        {
          "src": "http://localhost/humhub/olan.net/olan-net-chat-192.png",
          "sizes": "192x192"
        }
      ]
    },
    {
      "name": "Tasks",
      "short_name": "Tasks",
      "description": "Overview of my tasks",
      "url": "http://localhost/humhub/olan.net/tasks/global?source=pwa",
      "icons": [
        {
          "src": "http://localhost/humhub/olan.net/olan-net-tasks-192.png",
          "sizes": "192x192"
        }
      ]
    },
    {
      "name": "Calendar",
      "short_name": "Calendar",
      "description": "Overview calendar",
      "url": "http://localhost/humhub/olan.net/calendar/global?source=pwa",
      "icons": [
        {
          "src": "http://localhost/humhub/olan.net/olan-net-calendar-192.png",
          "sizes": "192x192"
        }
      ]
    }
  ],
  "screenshots": [
    {
      "src": "http://localhost/humhub/olan.net/screenshot1.png",
      "type": "image/png",
      "sizes": "360x800"
    },
    {
      "src": "http://localhost/humhub/olan.net/screenshot2.png",
      "type": "image/jpg",
      "sizes": "960x600"
    }
  ],
  "share_target": {
    "action": "http://localhost/humhub/olan.net/custom/web-share/index",
    "enctype": "multipart/form-data",
    "method": "POST",
    "params": {
      "title": "name",
      "text": "description",
      "url": "link",
      "message": "message",
      "files": [
        {
          "name": "media[]",
          "accept": [
            "audio/*",
            "image/*",
            "video/*",
            "application/msword",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.ms-powerpoint",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation"
          ]
        }
      ]
    }
  }
}</pre>
</div>
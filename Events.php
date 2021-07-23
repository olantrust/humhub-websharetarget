<?php

namespace  olan\websharetarget;

use humhub\modules\admin\permissions\ManageSettings;
use humhub\modules\ui\menu\MenuLink;
use Yii;
use yii\helpers\ArrayHelper;
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
            'label' => 'Edit Manifest',
            'url' => Url::to(['/websharetarget/manifest']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-share-alt"></i>',
            'isActive'  => MenuLink::isActiveState('websharetarget', 'manifest'),
            'sortOrder' => 701,
        ]);
    }

    public static function onSettingsMenuInit($event)
    {
      $canEditSettings = Yii::$app->user->can(ManageSettings::class);

      $event->sender->addEntry(new MenuLink([
          'label'     => "Manifest",
          'url'       => Url::to(['/websharetarget/manifest']),
          'sortOrder' => 201,
          'isActive'  => MenuLink::isActiveState('websharetarget', 'manifest'),
          'isVisible' => $canEditSettings
      ]));
    }

     /**
     * Overwrite Manifest.json file.
     *
     * @param $event
     * @return Json
     */
    public static function onManifestControllerInit($event)
    {
      $theme_color      = Yii::$app->view->theme->variable('primary');
      $background_color = Yii::$app->view->theme->variable('background-color-main');

      if (!empty($_COOKIE['dusk']) && $_COOKIE['dusk'] == 'yes') {
          $theme_color = '#0d0f19';
          $background_color = '#191e38';
      } else if (!empty($_COOKIE['autumn']) && $_COOKIE['autumn'] == 'yes') {
          $theme_color = '#B06502';
          $background_color = '#DBBD6B';
      } else if (!empty($_COOKIE['blossom']) && $_COOKIE['blossom'] == 'yes') {
          $theme_color = '#FFCCCD';
          $background_color = '#FCEDED';
      } else if (!empty($_COOKIE['forest']) && $_COOKIE['forest'] == 'yes') {
          $theme_color = '#495630';
          $background_color = '#9EB865';
      } else if (!empty($_COOKIE['marine']) && $_COOKIE['marine'] == 'yes') {
          $theme_color = '#044147';
          $background_color = '#DDEBF6';
      } else if (!empty($_COOKIE['berry']) && $_COOKIE['berry'] == 'yes') {
          $theme_color = '#3E3663';
          $background_color = '#8F6DAB';
      } else if (!empty($_COOKIE['amaranth']) && $_COOKIE['amaranth'] == 'yes') {
          $theme_color = '#5C1120';
          $background_color = '#BF5A6E';
      }

      // unset($event->sender->manifest['theme_color']);
      // unset($event->sender->manifest['background_color']);

      $shortcuts = [];
      if(!Yii::$app->user->isGuest)
      {
        $shortcuts[] = [
          'name' => 'My Profile',
          'short_name' => 'My Profile',
          'description' => 'Open My Profile page',
          'url' => Yii::$app->user->identity->createUrl('/user/profile/home', ['source' => 'pwa'], true),
          'icons' => [
            'src' => Url::toRoute('/', true) . 'olan-net-chat-192.png',
            'sizes' => '192x192'
          ]
        ];
      }

      // echo '<pre>';
      // print_r($shortcuts);
      // exit;

      $manifest = [
        'scope' => Url::to(['/'], true),
        'description' => 'Sharing, collaborating and workflow service community for Olan members, supporters and groups',
        'orientation' => 'portrait',
        'dir' => 'ltr',
        'lang' => Yii::$app->language,
        'theme_color'  => $theme_color,
        'background_color' => $background_color,
        'shortcuts' => ArrayHelper::merge($shortcuts, [
          [
            'name' => 'Messages',
            'short_name' => 'Messages',
            'description' => Yii::$app->name . ' messaging app',
            'url' => Url::toRoute(['/mail/mail/index', ['source' => 'pwa']], true),
            'icons' => [[
              'src' => Url::toRoute('/', true) . 'olan-net-chat-192.png',
              'sizes' => '192x192'
            ]]
          ],
          [
            'name' => 'Tasks',
            'short_name' => 'Tasks',
            'description' => 'Overview of my tasks',
            'url' => Url::toRoute(['/tasks/global', ['source' => 'pwa']], true),
            'icons' => [[
              'src' => Url::toRoute('/', true) . 'olan-net-tasks-192.png',
              'sizes' => '192x192'
            ]]
          ],
          [
            'name' => 'Calendar',
            'short_name' => 'Calendar',
            'description' => 'Overview calendar',
            'url' => Url::toRoute(['/calendar/global', ['source' => 'pwa']],true),
            'icons' => [[
              'src' => Url::toRoute('/',true) . 'olan-net-calendar-192.png',
              'sizes' => '192x192'
            ]]
          ]
        ]),
        'screenshots' => [
          [
            'src' => Url::toRoute('/',true) . 'screenshot1.png',
            'type' => 'image/png',
            'sizes' => '360x800'
          ],
          [
            'src' => Url::toRoute('/',true) . 'screenshot2.png',
            'type' => 'image/jpg',
            'sizes' => '960x600'
          ]
        ],
        'share_target' => [
          'action' => Url::toRoute('/websharetarget/index',true),
          'enctype' => 'multipart/form-data',
          'method' => 'POST',
          'params' => [
            "title" => "name",
            "text" => "description",
            "url" => "link",
            "message" => "message",
            'files' => [
              [
                'name' => 'media[]',
                'accept' => [
                  'audio/*',
                  'image/*',
                  'video/*',
                  'application/msword', // Doc files
                  'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Docx files
                  'application/vnd.ms-excel', // Xls files
                  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // Xlsx files
                  'application/vnd.ms-powerpoint',  // PPT files
                  'application/vnd.openxmlformats-officedocument.presentationml.presentation' // pptx files
                ]
              ]
            ]
          ]
        ],
        'prefer_related_applications' => true,
        'related_applications' => [
          [
            'platform' => 'play',
            'url' => 'https://play.google.com/store/apps/details?id=net.olan.pwa',
            'id'  => 'net.olan.pwa',
          ],
          [
            'platform' => 'webapp',
            'url' => Url::toRoute('/', true) . 'manifest.json',
          ],
          [
              "platform" => "Windows App Store",
              "url" => "https://www.microsoft.com/store/apps/9P388QPP1RTB"
          ]
        ]
      ];

      $manifest = ArrayHelper::merge($event->sender->manifest, $manifest);

      // ksort($manifest);

      return $event->sender->asJson($manifest);
    }
}

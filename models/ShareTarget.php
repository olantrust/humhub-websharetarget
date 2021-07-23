<?php

namespace olan\websharetarget\models;

use humhub\modules\content\models\ContentContainer;
use humhub\modules\content\widgets\WallCreateContentForm;
use humhub\modules\file\libs\FileHelper;
use humhub\modules\file\libs\ImageHelper;
use humhub\modules\post\models\Post;
use humhub\modules\file\models\File;
use humhub\modules\space\models\Membership;
use humhub\modules\user\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Accepting Share through Web Share Target API
 * @link https://github.com/w3c/web-share-target
 */
class ShareTarget extends DynamicModel
{
    var $message, $files, $fileList, $guid;

    public function __construct()
    {
        $this->defineAttribute('message', '');
        $this->defineAttribute('fileList', '');

        $this
        ->addRule(['message', 'guid'], 'required')
        ->addRule(['fileList'], 'safe')
        ->addRule(['files'], 'file', ['skipOnEmpty' => true, 'mimeTypes' => ["audio/*", "image/*", "video/*", "*.doc", "*.docx", "*.pdf", "*.xlsx", "*.ppt"], 'maxFiles' => Yii::$app->getModule('content')->maxAttachedFiles]);
    }

    /**
     * Label values
     */
    public function attributeLabels()
    {
        return [
            'guid'  => 'Share to',
        ];
    }

    /**
     * Save Post details on given Content Container.
     * Content Container can be any (User or a Space)
     */
    public function savePost()
    {
        $contentContainer = ContentContainer::findRecord($this->guid);

        $post = new Post($contentContainer);
        $post->message = $this->message;

        if($post->save())
        {
            if(!empty($this->fileList) && is_array($this->fileList))
            {
                foreach($this->fileList as $fileGuid)
                {
                    $file = File::findOne(['guid' => $fileGuid]);

                    if($file)
                    {
                        $post->fileManager->attach($file);
                    }
                }
            }
        }
    }

    /**
     * Upload files to Humhub
     */
    public function upload()
    {
        $file_guids = [];
        if(!empty($this->files))
        {
            foreach($this->files as $file)
            {
                $humhubFile = new \humhub\modules\file\models\File();
                $humhubFile->file_name = $file->baseName . '.' . $file->extension;
                $humhubFile->mime_type = $file->type;
                $humhubFile->size      = $file->size;

                if ($humhubFile->save())
                {
                    $humhubFile->store->set($file);

                    $file_guids[$humhubFile->guid] = $humhubFile->guid;

                    Yii::warning(Json::encode($file_guids));

                    ImageHelper::downscaleImage($humhubFile);
                }
                else
                {
                    Yii::error($humhubFile->getErrors());
                }
            }
        }

        return $file_guids;
    }

    public static function getContentContainerOptions($user_guid)
    {
        $user = User::find()->joinWith('spaces')
                ->where([User::tableName() . '.guid' => $user_guid])
                // ->orderBy(Membership::tableName() . '.`last_visit` DESC')
                ->one();

        $spaces = $user->spaces;

        $options = [$user->guid => 'My Profile'];
        $options = ArrayHelper::merge($options, ArrayHelper::map($spaces, 'guid', 'name'));

        return $options;
    }
}
<?php

namespace olan\websharetarget\controllers;

use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use humhub\components\Controller;
use humhub\components\access\ControllerAccess;
use olan\websharetarget\models\ShareTarget;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

class IndexController extends Controller
{
    /**
     * Allow guest access independently from guest mode setting.
     *
     * @var string
     */
    public $access = ControllerAccess::class;

    public $enableCsrfValidation = false;

    // public $layout = '@humhub/modules/user/views/layouts/main';

    public $subLayout = "@websharetarget/views/layouts/web-share";

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->redirect(Url::toRoute('/user/auth/login'));
        }

        // $this->layout    = false;
        // $this->subLayout = false;

        $user = Yii::$app->user->identity;

        $request = $file_guids = [];

        $model = new ShareTarget();

        // Android devices don't post method when direct file sharing.
        $files = $this->getFiles();

        if (Yii::$app->request->post() || !empty($files))
        {

            $model->fileList = Yii::$app->request->post('fileList');
            $file_guids = (!empty($model->fileList) ? $model->fileList : []);

            if($model->load(Yii::$app->request->post()) && $model->validate())
            {
                $model->savePost();

                return $this->redirect($user->createUrl('/user/profile/home'));
            }
            else
            {
                if(!empty($model->getErrors()))
                {
                    Yii::error($model->getErrors());
                }
            }

            $title = Yii::$app->request->post('title');
            $text  = Yii::$app->request->post('text');
            $url   = Yii::$app->request->post('url');

            if(!empty($title) || !empty($text) || !empty($url))
            {
                $model->message = '**' . $title . '**' . "\n\n" . $text . "\n\n" . $url ;
            }
            else if(!empty($files))
            {
                $names = ArrayHelper::map($files, 'name', 'name');

                // $model->message = implode(', ', $names);
                $model->message = Yii::t('app', 'Sharing {count} Files', ['count' => count($files)]);
            }

            // Get multiple files.
            // $files = $this->getFiles();

            if(!empty($files))
            {
                $request = ArrayHelper::merge(Yii::$app->request->post(), ['files' => $files]);

                $model->files = $files;
                $file_guids = $model->upload();
            }
            else
            {
                $request = Yii::$app->request->post();
            }

            Yii::warning(Json::encode($request));
        }

        return $this->render('index', [
            'model'             => $model,
            'file_guids'        => $file_guids,
            'request'           => $request,
            'user'              => $user,
            'contentContainers' => ShareTarget::getContentContainerOptions($user->guid),
        ]);
    }

    /**
     * Get Uploaded files.
     */
    private function getFiles()
    {
        $files = UploadedFile::getInstancesByName('media');

        if(empty($files))
        {
            $files = UploadedFile::getInstanceByName('media');
        }

        return $files;
    }
}


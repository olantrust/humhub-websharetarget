<?php

namespace olan\websharetarget\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\admin\permissions\ManageSettings;
use olan\websharetarget\models\Manifest;

class ManifestController extends Controller
{

    public function getAccessRules()
    {
        return [
            ['permission' => ManageSettings::class]
        ];
    }

    /**
     * Render admin only page
     *
     * @return string
     */
    public function actionIndex()
    {
        $module = Yii::$app->getModule('websharetarget');

        $this->subLayout = '@admin/views/layouts/setting';

        $model = new Manifest();

        // Save data
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save())
        {
            $model->saveFile();

            $this->view->saved();
            return $this->redirect(['index']);
        }

        $model->content = $module->settings->get('manifest.json');

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}


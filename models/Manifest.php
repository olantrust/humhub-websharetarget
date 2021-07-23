<?php

namespace olan\websharetarget\models;

use Yii;
use yii\helpers\Json;

class Manifest extends \humhub\models\Setting
{
    var $content;

    /**
     * Define Validation rules
     */
    public function rules()
    {
        return [
            ['content', 'required'],
            ['content', 'verifyJson'],
        ];
    }

    public function verifyJson($attribute, $params, $validator)
    {
        if (!json_decode($this->$attribute, true)) {
            $this->addError($attribute, 'Please provide a valid JSON input.');
        }
    }

    /**
     * Save the value in database
     */
    public function save($runValidation = true, $attributeNames = NULL)
    {
        $module = Yii::$app->getModule('websharetarget');

        $module->settings->set('manifest.json', $this->content);

        return true;
    }

    public function saveFile()
    {
        $manifest_content = Yii::$app->getModule('websharetarget')->settings->get('manifest.json');
        $manifest_file    = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'manifest.json';

        $fp = fopen($manifest_file, 'w+');
        fwrite($fp, $manifest_content);
        fclose($fp);
    }
}
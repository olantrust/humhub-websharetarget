<?php

use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="panel panel-default">
    <div class="panel-heading">Testing Form</div>
    <div class="panel-body">
        <!-- Testing form -->
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>

            <div class="row">
                <div class="col-sm-3">
                    <?= Html::input('text', 'title', 'This is Title', ['class' => 'form-control', 'placeholder' => 'Title']); ?>
                </div>

                <div class="col-sm-3">
                    <?= Html::input('text', 'text', 'This is Text', ['class' => 'form-control', 'placeholder' => 'Text']); ?>
                </div>

                <div class="col-sm-3">
                    <?= Html::input('text', 'url', Url::toRoute('/', true), ['class' => 'form-control', 'placeholder' => 'Url']); ?>
                </div>

                <div class="col-sm-3">
                    <?= Html::fileInput('media[]', null, ['class' => 'form-control', 'placeholder' => 'Select Files', 'multiple' => true, 'accept' => 'image/*']); ?>
                </div>
            </div>

            <div class="text-right btn_container"><Br />
                <?php echo Button::save('Send Test Data')->submit() ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
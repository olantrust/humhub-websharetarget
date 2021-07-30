<?php

use humhub\libs\LogoImage;
use humhub\modules\content\widgets\richtext\RichTextField;
use humhub\modules\file\widgets\FilePreview;
use humhub\modules\file\widgets\UploadButton;
use humhub\modules\file\widgets\UploadProgress;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\widgets\Button;
use humhub\widgets\FooterMenu;
use humhub\widgets\SiteLogo;
use yii\helpers\Html;

$title = 'Share';
$this->setPageTitle($title);

// Register our module assets, this could also be done within the controller
// \olan\custom\assets\Assets::register($this);

$this->registerCss('
#topbar-first, #topbar-second {display:none}
body {padding-top:50px !important}
');

?>
<div class="panel panel-default" style="text-align:left">
    <div class="panel-heading" style="padding:0">
        <?php if (LogoImage::hasImage()) : ?>
            <img class="img-rounded" src="<?= LogoImage::getUrl(128, 80); ?>" alt="<?= Html::encode(Yii::$app->name) ?>" id="img-logo" style="padding:5px;margin:10px" />
            &nbsp;
        <?php else: ?><div class="no-logo"><?= Html::encode(Yii::$app->name) ?></div><?php endif; ?><?= $title ?> On <?= Yii::$app->name ?>
    </div>

    <div class="panel-body">
        <?php // echo \humhub\modules\post\widgets\Form::widget(['contentContainer' => $user]); ?>

        <?php $form = ActiveForm::begin([
            'enableClientValidation' => true,
        ]); ?>

            <?= $form->field($model, 'guid')->dropDownList($contentContainers, ['prompt' => 'Please Select']); ?>
            <?= $form->field($model, 'message')->widget(RichTextField::class, ['pluginOptions' => ['maxHeight' => '300px']])->label(false); ?>

        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <?= UploadProgress::widget(['id' => 'contentFormFiles_progress']) ?>
                <?= FilePreview::widget([
                        'id'    => 'contentFormFiles_preview',
                        'items' => $file_guids,
                        'edit'  => true,
                        // 'options' => ['style' => 'margin-top:10px;']
                    ]); ?>
            </div>

            <div class="col-xs-12 col-sm-4">
                <div class="text-right btn_container">
                    <?= UploadButton::widget([
                            'id'             => 'contentFormFiles',
                            'tooltip'        => Yii::t('ContentModule.base', 'Attach Files'),
                            'progress'       => '#contentFormFiles_progress',
                            'preview'        => '#contentFormFiles_preview',
                            'dropZone'       => '#contentFormBody',
                            'max'            => Yii::$app->getModule('content')->maxAttachedFiles,
                            'cssButtonClass' => 'btn-primary'
                        ]);
                    ?>
                    <?php //echo Html::submitButton() ?>
                    <?= Button::save('Submit')->submit() ?>
                    <?= Button::asLink('Cancel', $user->createUrl('/user/profile/home'))->pjax(false)->confirm('Are you sure?', 'All your data will be discarded and<Br />you will redirect to your profile.')->cssClass('btn btn-danger') ?>
                </div>
            </div>
        </div>
        <?php foreach($file_guids as $file_guid): ?>
            <input type="hidden" name="fileList[]" value="<?= $file_guid ?>" />
        <?php endforeach ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php echo FooterMenu::widget(); ?>
<?php //echo $this->render('_test-form'); ?>
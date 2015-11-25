<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use aca\common\helpers\Utility;
use aca\backend\widgets\box\Box;
use aca\fileManager\widgets\uploader\SingleImageUpload;
?>
<?php Box::begin([
    'title' => 'اطلاعات عکس',
]) ?>
    <div class="gallery-form">
        <?php
        /*
            when loading form via ajax, for cliendside and ajax validation to work,
            specifying form id is MANDATORY!
        */
        $form = ActiveForm::begin([
            'enableClientValidation' => true,
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'gallery-form'
        ]);
        ?>
        <?= Html::activeInput('hidden', $model, "galleryId") ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            <?php
                echo SingleImageUpload::widget(
                    [
                        'model' => $model,
                        'group' => 'gallery_image',
                        'folderName' => 'gallery',
                        'label' => ''
                    ]
                );
            ?>
            </div>
        </div>
        <hr>
        <?= $form->field($model, 'title')->textInput(
            ['maxlength' => 255, 'class'=>'form-control input-xlarge']
        ) ?>
        <?= $form->field($model, 'description')->textarea(
            ['rows' => 6, 'class'=>'form-control input-xlarge']
        ) ?>
        <?= $form->field($model, 'link')->textInput([
            'maxlength' => 512,
            'class' => 'form-control input-xlarge',
            'style' => 'direction:ltr',
        ]) ?>
        <?= $form->field($model, 'order')
            ->dropDownList(
                Utility::listNumbers(1, 20),
                ['class' => 'form-control input-medium']
            )
        ?>
        <?php ActiveForm::end(); ?>
    </div>
<?php Box::end();

$this->registerJs('
    $(document).ready(function () {
        $(".modal-inner").trigger("pageReady");
    });
');

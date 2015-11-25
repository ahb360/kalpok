<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kalpok\gallery\models\Image;
use aca\backend\widgets\box\Box;
use aca\backend\assetbundles\ModalFormAsset;
use aca\backend\widgets\button\Button;

ModalFormAsset::register($this);
?>
<div class="gallery-index">
    <?= Button::widget([
        'title' => 'افزودن عکس',
        'icon' => 'plus',
        'color' => 'green',
        'url' => ['/gallery/add-image', 'galleryId' => $gallery->id],
        'options' => [
            'class' => 'btn btn-app ajaxcreate',
            'data-gridpjaxid' => 'gallery-grid',
            'data-modalheader' => 'افزودن عکس به گالری',
            'data-modalfooterbtns' => 'true',
        ]
    ]); ?>

    <?php if (isset($ownerId)) {
        echo Button::widget([
            'title' => 'بازگشت',
            'icon' => 'undo',
            'color' => 'blue',
            'url' => [
                'view',
                'id' => $ownerId,
            ],
            'options' => ['class' => 'btn btn-app']
        ]);

        echo Button::widget([
            'title' => 'حذف گالری',
            'icon' => 'trash',
            'color' => 'red',
            'url' => [
                '/gallery/delete',
                'id' => $gallery->id,
                'ownerId' => $ownerId,
                'returnUrl' => urlencode(Url::toRoute(['view', 'id' => $ownerId]))
            ],
            'options' => [
                'class' => 'btn btn-app',
                'data' => [
                    'method' => 'post',
                    'confirm' => "آیا از حذف گالری مطمئن هستید؟ \n با این کار همه عکس ها نیز حذف خواهند شد.",
                ]
            ]
        ]);
    } ?>

    <?php Box::begin([
        'title' => 'عکس های گالری',
        'options' => ['class' => 'box-solid box-primary'],
    ]) ?>
        <?php Pjax::begin([
            'id' => 'gallery-grid',
            'enablePushState' => false,
        ]); ?>
            <?= GridView::widget([
                'dataProvider' => $gallery->search(),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'class' => 'aca\backend\grid\ThumbnailColumn',
                        'group' => 'gallery_image',
                        'preset' => 'gallery-grid',
                        'label' => false,
                        'options' => ['style' => 'width:25%;']
                    ],
                    'title',
                    ['class' => 'aca\backend\grid\LinkColumn'],
                    [
                        'class' => 'aca\backend\grid\AjaxActionColumn',
                        'controller' => '/gallery',
                        'options' => ['style' => 'width:7%'],
                        'template' => '{edit-image} {remove-image}',
                        'viewModalHeader' => 'مشاهده اطلاعات عکس',
                        'updateModalHeader' => 'ویرایش اطلاعات عکس',
                        'buttons' => [
                            'edit-image' => function ($url, $model, $key) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-pencil"></span>',
                                    $url,
                                    [
                                        'title' => 'ویرایش عکس',
                                        'data-pjax' => '0',
                                        'data-modalheader' => 'ویرایش عکس',
                                        'data-modalfooterbtns' => 'true',
                                        'class' => 'ajaxupdate'
                                    ]
                                );
                            },
                            'remove-image' => function ($url, $model, $key) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-trash"></span>',
                                    $url,
                                    [
                                        'title' => 'حذف عکس',
                                        'data-confirmmsg' => 'آیا از حذف عکس مطمئن هستید؟',
                                        'data-pjax' => '0',
                                        'class' => 'ajaxdelete',
                                    ]
                                );
                            }
                        ]
                    ]
                ]
            ]); ?>
        <?php Pjax::end(); ?>
    <?php Box::end() ?>
</div>

<?php
Modal::begin([
    'id' => 'admin-modal',
    'clientOptions' => ['backdrop' => false],
]);
?>
<div class="modal-inner"></div>
<?php Modal::end();

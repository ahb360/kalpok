<?php
namespace kalpok\file\widgets\singleupload;

use yii\web\AssetBundle;

class SingleUploadAsset extends AssetBundle
{
    public $sourcePath = '@kalpok/file/widgets/singleupload/assets';
    public $css = [
        'styles.css',
    ];
    public $js = [
        'main.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}

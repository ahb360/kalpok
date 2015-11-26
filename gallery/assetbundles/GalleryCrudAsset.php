<?php
namespace kalpok\gallery\assetbundles;

use yii\web\AssetBundle;

class GalleryCrudAsset extends AssetBundle
{
    public $sourcePath = '@kalpok/gallery/assets';
    public $js = [
        'main.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}

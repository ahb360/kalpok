<?php
namespace kalpok\gallery\widgets\assetbundles;

use yii\web\AssetBundle;

class MagnificPopupAsset extends AssetBundle
{
    public $sourcePath = '@kalpok/gallery/widgets/assets/magnific-popup';
    public $js = [
        'dist/jquery.magnific-popup.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'dist/magnific-popup.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'kalpok\gallery\widgets\assetbundles\OwlCarouselAsset'
    ];
}

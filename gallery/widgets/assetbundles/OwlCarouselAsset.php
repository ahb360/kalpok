<?php
namespace kalpok\gallery\widgets\assetbundles;

use yii\web\AssetBundle;

class OwlCarouselAsset extends AssetBundle
{
    public $sourcePath = '@aca/gallery/widgets/assets/owlcarousel';
    public $js = [
        'owl-carousel/owl.carousel.min.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_END];
    public $css = [
        'owl-carousel/owl.carousel.css',
        'owl-carousel/owl.theme.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}

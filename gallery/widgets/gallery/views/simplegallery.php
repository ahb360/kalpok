<?php
use yii\web\View;
use aca\common\helpers\Html;
use kalpok\gallery\widgets\assetbundles\OwlCarouselAsset;

OwlCarouselAsset::register($this);
?>
<div class="simple-gallery-widget widget" style="direction:ltr">
    <div class="carousel-container">
        <div id="owl-<?php echo $this->context->id ?>" class="owl-carousel">
            <?php  foreach ($images as $image) : ?>
                <div class="item">
                    <?php
                        $alt = null;
                        if (!empty($image->title) and !empty($image->description)) {
                            $alt = '<h3>'.$image->title.'</h3> <p>'.$image->description.'</p>';
                        } else if (!empty($image->title)) {
                            $alt = '<h3>'.$image->title.'</h3>';
                        } else if (!empty($image->description)) {
                            $alt = '<p>'.$image->description.'</p>';
                        }
                    ?>
                    <img class="lazyOwl"  data-src="<?php echo $image->getUrl('gallery-thumb'); ?>" data-orig="<?php echo $image->getUrl('gallery-big'); ?>" data-mfp-src="<?php echo $image->getUrl('gallery-big'); ?>" data-description="<?php echo $alt ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="custom-navigation">
            <a class="btn btn-default prev"><i class="fa fa-chevron-right"></i></a>
            <a class="btn btn-default next"><i class="fa fa-chevron-left"></i></a>
        </div>
    </div>
    <div id="gallery-<?php echo $this->context->id ?>" class="gallery-main-container"></div>
</div>

<?php
$this->registerJs(
    '
    $(document).ready(function() {
        var owl = $("#owl-'.$this->context->id.'");
        owl.owlCarousel('.str_replace('"', '', $this->context->clientOptions).');
        $(".lazyOwl").on("click", function(event){
            event.preventDefault();
            var $this = $(this);
            var $src = $this.data("orig");
            var $description = $this.data("description");
            PreloadImage($src, $description);
        });
        function afterAction() {
            var current = this.owl.currentItem;
            var $src = $(this.owl.owlItems[current]).find("img").data("orig");
            var $description = $(this.owl.owlItems[current]).find("img").data("description");
            PreloadImage($src, $description);
        }
    });
    $(".next").click(function(){
        $("#owl-'.$this->context->id.'").trigger(\'owl.next\');
    })
    $(".prev").click(function(){
        $("#owl-'.$this->context->id.'").trigger(\'owl.prev\');
    })
    function PreloadImage(imgSrc, description){
        var objImagePreloader = new Image();
        objImagePreloader.src = imgSrc;
        if (objImagePreloader.complete) {
            showImage(imgSrc, description);
        } else {
            $("#gallery-'.$this->context->id.'").html("<i class=\'fa fa-spinner fa-spin\'></i>")
            objImagePreloader.onload = function() {
                showImage(imgSrc, description);
            }
        }
    }
    function showImage(imgSrc, description) {
        $(\'#gallery-'.$this->context->id.'\').html(\'<img id="theImg" class="img-responsive" src="\'+imgSrc+\'" /><div>\'+description+\'</div>\')
    }
    ',
    View::POS_END,
    'sliderReady'.$this->context->id
);
$this->registerCss(
    '
        .simple-gallery-widget {
            background: #ddd;
            direction: ltr;
            padding: 5px;
        }
        .simple-gallery-widget .item{
            margin: 3px;
        }
        .simple-gallery-widget .item:hover {
            cursor: grab;
        }
        .simple-gallery-widget .item img {
            display: block;
            width: 100%;
            height: auto;
        }
        .simple-gallery-widget .gallery-main-container {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }
        .simple-gallery-widget .gallery-main-container img {
            width: 100%;
        }
        .simple-gallery-widget .gallery-main-container img {
            display: inline;
        }
        .simple-gallery-widget .gallery-main-container .loading {
            margin-top: 40px;
        }
        .owl-item.loading {
            min-height: auto;
        }
        .simple-gallery-widget .carousel-container {
            position: relative;
        }
        .custom-navigation .prev {
            position: absolute;
            left: 0;
            top: 40%;
        }
        .custom-navigation .next {
            position: absolute;
            right: 0;
            top: 40%;
        }
        .gallery-main-container div {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: right;
        }
        .gallery-main-container div h3, .gallery-main-container div p {
            background: rgba(255,255,255, 0.5);
        }
        .gallery-main-container div h3 {
            margin: 0;
            padding: 10px 10px 8px;
        }
        .gallery-main-container div p {
            margin: 0;
            padding: 0 10px 10px;
        }
    ',
    [],
    'sliderCss'
);

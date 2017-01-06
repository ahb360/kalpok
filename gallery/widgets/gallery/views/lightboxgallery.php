<?php
use yii\web\View;
use yii\helpers\Html;
use kalpok\gallery\widgets\assetbundles\MagnificPopupAsset;

MagnificPopupAsset::register($this);
?>

<div class="simple-gallery-widget widget" style="direction:ltr">
    <div id="gallery-<?php echo $this->context->id ?>" class="gallery-main-container"></div>
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
</div>

<?php
$this->registerJs(
    '
    $(document).ready(function() {
        var owl = $("#owl-'.$this->context->id.'");
        owl.owlCarousel('.str_replace('"', '', $this->context->clientOptions).');
    });
    $(".next").click(function(){
        $("#owl-'.$this->context->id.'").trigger(\'owl.next\');
    })
    $(".prev").click(function(){
        $("#owl-'.$this->context->id.'").trigger(\'owl.prev\');
    })
    $(".owl-carousel").magnificPopup({
      delegate: "img", // child items selector, by clicking on it popup will open
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0,1] // Will preload 0 - before current, and 1 after the current image
      },
      image: {
        tError: \'<a href="%url%">The image #%curr%</a> could not be loaded.\',
        titleSrc: function(item) {
          return item.el.attr("data-description");
        }
      }
    });
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
        .gallery-main-container {
          display: none;
        }
        .mfp-bottom-bar h3 {
          margin: 0 0 3px;
        }
        .mfp-bottom-bar .mfp-title {
          font-size: 0.8em;
        }
        .mfp-bottom-bar .mfp-counter {
          direction: ltr;
        }
    ',
    [],
    'sliderCss'
);

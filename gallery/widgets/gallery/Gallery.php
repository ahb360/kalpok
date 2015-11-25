<?php
namespace kalpok\gallery\widgets\gallery;

use yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Gallery extends Widget
{
    public $view = 'simplegallery';
    public $images;
    public $id = '';
    public $clientOptions = [];

    public function init()
    {
        $this->clientOptions = ArrayHelper::merge([
            'items'=>6,
            'lazyLoad'=>true,
            'navigation'=>false,
            'pagination'=>false
        ], $this->clientOptions);
        $this->clientOptions = Json::encode($this->clientOptions);
    }

    public function run()
    {
        if (empty($this->images)) {
            return;
        }
        return $this->render(
            $this->view,
            [
                'images' => $this->images,
            ]
        );
    }
}

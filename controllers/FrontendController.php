<?php

namespace core\controllers;

use Yii;
use yii\web\Controller;

class FrontendController extends Controller
{
    public $layout = '@core/views/frontend/layouts/main.php';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@core/views/frontend/error.php'
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('@core/views/frontend/index.php');
    }
}

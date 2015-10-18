<?php

namespace kalpok\controllers;

use Yii;
use yii\web\Controller;

class FrontendController extends Controller
{
    public $layout = '@app/views/frontend/layouts/main.php';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/frontend/error.php'
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('@app/views/frontend/index.php');
    }
}

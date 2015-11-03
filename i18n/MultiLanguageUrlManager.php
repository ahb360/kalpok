<?php
namespace kalpok\i18n;

use Yii;

class MultiLanguageUrlManager extends \yii\web\UrlManager
{
    public $ruleConfig = ['class' => '\kalpok\i18n\MultiLanguageUrlRule'];

    public function createUrl($params)
    {
        $params = (array) $params;
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }

        return parent::createUrl($params);
    }

    public function createAbsoluteUrl($params, $scheme = null)
    {
        $params = (array) $params;
        if (!isset($params['language'])) {
            $params['language'] = Yii::$app->language;
        }

        return parent::createAbsoluteUrl($params);
    }
}

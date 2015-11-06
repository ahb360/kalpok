<?php
namespace kalpok\i18n;

class View extends \yii\web\View
{
    public function isRTL()
    {
        return LanguageBuilder::build(\Yii::$app->language)->direction ==
            Language::DIRECTION_RTL;
    }
}

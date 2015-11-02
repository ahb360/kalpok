<?php
namespace kalpok\di;

use Yii;
use yii\base\BootstrapInterface;

class RegisterDependencies implements BootstrapInterface
{
    public function bootstrap($app){
        Yii::$container->set('language', 'kalpok\i18n\Language');
        Yii::$container->setSingleton('kalpok\i18n\Language', function () {
            return \kalpok\i18n\LanguageBuilder::build(Yii::$app->language);
        });

        Yii::$container->set('calendar', 'kalpok\i18n\Calendar');
        Yii::$container->setSingleton('kalpok\i18n\Calendar', function () {
            return \kalpok\i18n\CalendarBuilder::build(Yii::$app->language);
        });
    }
}

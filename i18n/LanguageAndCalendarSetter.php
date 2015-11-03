<?php
namespace kalpok\i18n;

use Yii;
use yii\base\BootstrapInterface;

class LanguageAndCalendarSetter implements BootstrapInterface
{
    public function bootstrap($app){
        self::setDependencies();
    }

    public static function set()
    {
        if (isset($_GET['language'])) {
            Yii::$app->language = $_GET['language'];
        }
        self::setDependencies();
    }

    private static function setDependencies()
    {
        Yii::$container->set('language', 'kalpok\i18n\Language');
        Yii::$container->setSingleton('kalpok\i18n\Language', function () {
            return LanguageBuilder::build(Yii::$app->language);
        });

        Yii::$container->set('calendar', 'kalpok\i18n\Calendar');
        Yii::$container->setSingleton('kalpok\i18n\Calendar', function () {
            return CalendarBuilder::build(Yii::$app->language);
        });
    }
}

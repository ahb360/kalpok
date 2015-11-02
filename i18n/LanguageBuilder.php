<?php
namespace kalpok\i18n;

class LanguageBuilder
{
    public static function build($applicationLanguage)
    {
        switch ($applicationLanguage) {
            case 'fa':
                return new Language('fa', 'فارسی', 'rtl');
            case 'en':
                return new Language('en', 'انگلیسی', 'ltr');
            case 'ar':
                return new Language('ar', 'عربی', 'rtl');
            default:
                throw new \Exception("Unknown Language Code");
        }
    }
}

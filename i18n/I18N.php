<?php
namespace kalpok\i18n;

use Yii;
use DateTimeZone;
use aca\common\helpers\Utility;
use yii\helpers\FormatConverter;

class I18N extends \yii\i18n\I18N
{
    public $languages;

    protected $activeLanguage;

    private $farsiNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    private $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
    private $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    public function __construct(Language $language, $config = [])
    {
        $this->activeLanguage = $language;
        parent::__construct($config);
    }

    public function isMultiLanguage()
    {
        return is_array($this->languages);
    }

    public function availableLanguages()
    {
        if (!$this->isMultiLanguage())
            return [];

        foreach ($this->languages as $language) {
            $output[] = LanguageBuilder::build($language);
        }
        return $output;
    }

    /**
     * translates given number regarding to application language
     * @param  int $number
     * @return int
     */
    public function translateNumber($number)
    {
        if ($this->activeLanguage->code == 'fa') {
            $number = str_replace($this->arabicNumbers, $this->farsiNumbers, $number);
            return str_replace($this->englishNumbers, $this->farsiNumbers, $number);
        }elseif ($this->activeLanguage->code == 'ar') {
            $number = str_replace($this->farsiNumbers, $this->arabicNumbers, $number);
            return str_replace($this->englishNumbers, $this->arabicNumbers, $number);
        }else{
            $number = str_replace($this->farsiNumbers, $this->englishNumbers, $number);
            return str_replace($this->arabicNumbers, $this->englishNumbers, $number);
        }
    }

    public function convertArabicToFarsi($input)
    {
        $fa_num = array("۰","۱","۲","۳","۴","۵","۶","۷","۸","۹");
        $ar_num = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
        $ar_ch = array("ي", "ك", "دِ", "بِ", "زِ", "ذِ", "ِشِ", "ِسِ", "ى",'ئ','ؤ','ة','أ','إ');
        $fa_ch = array("ی", "ک", "د", "ب", "ز", "ذ", "ش", "س", "ی",'ی','و','ه','ا','ا');

        $input = str_replace($ar_num, $fa_num, $input);
        $input = str_replace($ar_ch, $fa_ch, $input);

        return $input;
    }
}

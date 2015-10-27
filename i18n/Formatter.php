<?php
namespace kalpok\i18n;

use Yii;
use DateTimeZone;
use aca\common\helpers\Utility;
use yii\helpers\FormatConverter;

class Formatter extends \yii\i18n\Formatter
{
    private $calendar;
    private $_intlLoaded = false;

    protected $dateObject;

    public function __construct(\kalpok\components\Date $dateObject, $config = [])
    {
        $this->dateObject = $dateObject;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        // TODO calendar should be set from somewhere
        $this->calendar = isset(Yii::$app->website) ? Yii::$app->website->calendar : 'jalali';
        $this->_intlLoaded = extension_loaded('intl');
    }

    public function asDate($value, $format = null, $calendar = null)
    {
        $calendar = $calendar ? $calendar : $this->calendar;
        if (!$calendar || $calendar == 'gregorian') {
            return parent::asDate($value, $format);
        }
        if ($format === null) {
            $format = $this->dateFormat;
        }
        return $this->formatDateTimeValue($value, $format, 'date');
    }

    public function asDatetime($value, $format = null, $calendar = null)
    {
        $calendar = $calendar ? $calendar : $this->calendar;
        if (!$calendar || $calendar == 'gregorian') {
            return parent::asDatetime($value, $format);
        }
        if ($format === null) {
            $format = $this->datetimeFormat;
        }
        return $this->formatDateTimeValue($value, $format, 'datetime');
    }

    public function asFarsiNumber($value)
    {
        if ($value === null) {
            return $this->nullDisplay;
        }
        return Yii::$app->i18n->translateNumber($value);
    }

    private function formatDateTimeValue($value, $format, $type)
    {
        $timeZone = $this->timeZone;
        // avoid time zone conversion for date-only values
        if ($type === 'date') {
            list($timestamp, $hasTimeInfo) = $this->normalizeDatetimeValue($value, true);
            if (!$hasTimeInfo) {
                $timeZone = $this->defaultTimeZone;
            }
        } else {
            $timestamp = $this->normalizeDatetimeValue($value);
        }
        if ($timestamp === null) {
            return $this->nullDisplay;
        }
        if (strncmp($format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            $format = FormatConverter::convertDateIcuToPhp($format, $type, $this->locale);
        }
        if ($timeZone != null) {
            if ($timestamp instanceof \DateTimeImmutable) {
                $timestamp = $timestamp->setTimezone(new DateTimeZone($timeZone));
            } else {
                $timestamp->setTimezone(new DateTimeZone($timeZone));
            }
        }
        return $this->dateObject->date($format, $timestamp->getTimestamp());
    }
}

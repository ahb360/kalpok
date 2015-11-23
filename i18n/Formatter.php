<?php
namespace kalpok\i18n;

use yii\helpers\FormatConverter;

class Formatter extends \yii\i18n\Formatter
{
    protected $calendar;
    protected $dateTime;
    protected $i18n;

    private $_intlLoaded = false;

    public function __construct(Calendar $calendar, DateTime $dateTime, I18N $i18n, $config = [])
    {
        $this->calendar = $calendar;
        $this->dateTime = $dateTime;
        $this->i18n = $i18n;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
        $this->_intlLoaded = extension_loaded('intl');
    }

    public function asLanguage($value)
    {
        if ($value == null)
            return $this->nullDisplay;

        return LanguageBuilder::build($value)->title;
    }

    public function asDate($value, $format = null)
    {
        if ($this->calendar->code == 'gregorian') {
            return parent::asDate($value, $format);
        }
        if ($format === null) {
            $format = $this->dateFormat;
        }
        return $this->formatDateTimeValue($value, $format, 'date');
    }

    public function asDatetime($value, $format = null)
    {
        if ($this->calendar->code == 'gregorian') {
            return parent::asDatetime($value, $format);
        }
        if ($format === null) {
            $format = $this->datetimeFormat;
        }
        return $this->formatDateTimeValue($value, $format, 'datetime');
    }

    public function asFarsiNumber($value)
    {
        if ($value === null)
            return $this->nullDisplay;

        return $this->i18n->translateNumber($value);
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
                $timestamp = $timestamp->setTimezone(new \DateTimeZone($timeZone));
            } else {
                $timestamp->setTimezone(new \DateTimeZone($timeZone));
            }
        }
        return $this->dateTime->date($format, $timestamp->getTimestamp());
    }
}

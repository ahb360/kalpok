<?php
namespace kalpok\components;

use Yii;
use yii\base\Component;
use kalpok\libs\JDateTime;
use yii\base\InvalidParamException;

class Date extends Component
{
    protected $jDate;

    public function __construct(JDateTime $jDate)
    {
        $this->jDate = $jDate;
    }

    public function date($format, $stamp = false)
    {
        switch ($this->getCalendar()) {
            case 'jalali':
                return $this->jDate->date($format, $stamp);
            case 'hijri':
                throw new \Exception("Hijri calendar is not supported yet");
            default:
                return date($format, $stamp);
        }
    }

    public function mktime($hour, $minute, $second, $month, $day, $year)
    {
        switch ($this->getCalendar()) {
            case 'jalali':
                return $this->jDate->mktime($hour, $minute, $second, $month, $day, $year);
            case 'hijri':
                throw new \Exception("Hijri calendar is not supported yet");
            default:
                return mktime($hour, $minute, $second, $month, $day, $year);
        }
    }

    public function strtotime($strdate, $format)
    {
        switch ($this->getCalendar()) {
            case 'jalali':
                return $this->jalaliStrtotime($strdate, $format);
            case 'hijri':
                return "";
            default:
                return strtotime($strdate);
        }
    }

    public function validate($date, $format)
    {
        $pd = date_parse_from_format($format, $date);
        return !($pd['error_count'] > 0
            or $pd['year'] > 1500
            or $pd['year'] < 1000
            or $pd['month'] > 12
            or $pd['month'] < 1
            or $pd['day'] > 31
            or $pd['day'] < 1);
    }

    public function getMonthName($monthNumber)
    {
        return $this->date("F", $this->mktime(0, 0, 0, $monthNumber, 1, 2011));
    }

    private function jalaliStrtotime($strdate, $format)
    {
        if (!$this->validate($strdate, $format)) {
            throw new InvalidParamException(
                "Given date string: {$strdate}, is not in form of given format: {$format}", 1);
        }
        $pd = date_parse_from_format($format, $strdate);
        return Yii::$app->date->mktime(
            $pd['hour'],
            $pd['minute'],
            $pd['second'],
            $pd['month'],
            $pd['day'],
            $pd['year']
        );
    }

    private function getCalendar()
    {
        return isset(Yii::$app->website) ? Yii::$app->website->calendar : 'jalali';
    }
}

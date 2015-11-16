<?php
namespace aca\common\validators;

use Yii;
use yii\validators\Validator;
use kalpok\helpers\Utility;
use yii\base\InvalidParamException;

class JalaliDateToTimestampValidator extends Validator
{
    public $format;
    public $hourAttr;
    public $minuteAttr;
    public $secondAttr;
    private $hour, $minute, $second = 0;

    public function init()
    {
        parent::init();
        if ($this->format === null) {
            $this->format = "Y/m/d|";
        }
        if ($this->message === null) {
            $format = Yii::$app->date->date($this->format);
            $this->message = "تاریخ باید در فرمت '{$format}' باشد";
        }
    }

    public function validateAttribute($model, $attribute)
    {
        if (Yii::$app->date->validate($model->$attribute, $this->format)) {
            $stamp = Yii::$app->date->strtotime($model->$attribute, $this->format);
            $this->setHourMinuteSecond($model);
            $model->$attribute =
                $stamp + ($this->hour * 3600) + ($this->minute * 60) + $this->second;
        } else {
            $this->addError($model, $attribute, $this->message);
        }
    }

    public function setHourMinuteSecond($model)
    {
        $hourAttr = $this->hourAttr;
        if (isset($hourAttr, $model->$hourAttr)) {
            $this->hour = $model->$hourAttr;
        }
        $minuteAttr = $this->minuteAttr;
        if (isset($minuteAttr, $model->$minuteAttr)) {
            $this->minute = $model->$minuteAttr;
        }
        $secondAttr = $this->secondAttr;
        if (isset($secondAttr, $model->$secondAttr)) {
            $this->second = $model->$secondAttr;
        }
    }
}

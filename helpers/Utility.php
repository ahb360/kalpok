<?php
namespace kalpok\helpers;

use Yii;

class Utility
{
    /**
     * mainly used in data input forms like when having priority field
     * @return array
     */
    public static function listNumbers($from, $to)
    {
        $list = [];
        $reverse = ($from > $to);
        if ($reverse) {
            for ($i=$from; $i >= $to ; $i--) {
                $list[$i] = Yii::$app->i18n->translateNumber($i);
            }
        }else{
            for ($i=$from; $i <= $to ; $i++) {
                $list[$i] = Yii::$app->i18n->translateNumber($i);
            }
        }
        return $list;
    }
}

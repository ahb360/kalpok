<?php
namespace core\helpers;

class FileHelper extends \yii\helpers\FileHelper
{
    public static function slug($string, $replacement = '-', $lowercase = true)
    {
        $string = preg_replace('/[^a-zA-Z0-9.=\s—–-]+/u', ' ', $string);
        $string = preg_replace('/[=\s—–-]+/u', $replacement, $string);
        $string = trim($string, $replacement);

        return $lowercase ? strtolower($string) : $string;
    }
}

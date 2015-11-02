<?php
namespace kalpok\i18n;

class Language
{
    public $code;
    public $title;
    public $direction;

    public function __construct($code, $title, $direction) {
        $this->code = $code;
        $this->title = $title;
        $this->direction = $direction;
    }
}

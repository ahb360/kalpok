<?php
namespace kalpok\i18n\widgets;

use Yii;
use yii\bootstrap\Html;
use yii\widgets\InputWidget;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class LanguageSelect extends InputWidget
{
    public function run()
    {
        if(isset($this->options['dependProperties'])) {
            if(!isset($this->options['dependProperties']['getDependentsUrl']) or !isset($this->options['dependProperties']['dependFieldId'])) {
                throw new InvalidConfigException('getDependentsUrl and dependFieldId properties must be set when you want depend drop down');
            }
        }
        if (Yii::$app->i18n->isMultiLanguage())
            $this->renderDropdown();
    }

    private function renderDropdown()
    {
        if(isset($this->options['dependProperties'])) {
            Yii::$app->controller->view->registerJs('
                $.get( "' . $this->options['dependProperties']['getDependentsUrl'] . '", {language : $( "#' . $this->options['id'] . '").val()})
                    .done(function(data){
                        $( "#' . $this->options['dependProperties']['dependFieldId'] . '").html(data);
                    }
                )
            ');
            $this->options['onchange'] = $this->getOnchangeRegisterJs();
        }
        if ($this->hasModel()) {
            echo Html::activeDropDownList($this->model, $this->attribute, $this->getItems(), $this->options);
        } else {
            echo Html::dropDownList($this->name, $this->value, $this->getItems(), $this->options);
        }
    }

    private function getItems()
    {
        return ArrayHelper::map(Yii::$app->i18n->availableLanguages(), 'code', 'title');
    }
    
    private function getOnchangeRegisterJs() {
        return '$.get( "' . $this->options['dependProperties']['getDependentsUrl'] . '", {language : $(this).val()})
                    .done(function(data){
                        $( "#category-list").html(data);
                    });';
    }
}

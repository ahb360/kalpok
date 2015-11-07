<?php
namespace kalpok\behaviors;

use kalpok\helpers\Inflector;

class SluggableBehavior extends \yii\behaviors\SluggableBehavior
{
    public $language;

    private function setLanguage()
    {
        if ($this->owner->hasAttribute('language')) {
            $this->language = $this->owner->language;
        }else{
            $this->language = \Yii::$app->language;
        }
    }

    public function getValue($event)
    {
        $this->setLanguage();
        if ($this->language != 'fa')
            return parent::getValue($event);

        $isNewSlug = true;
        if ($this->attribute !== null) {
            $attributes = (array) $this->attribute;
            /* @var $owner BaseActiveRecord */
            $owner = $this->owner;
            if (!empty($owner->{$this->slugAttribute})) {
                $isNewSlug = false;
                if (!$this->immutable) {
                    foreach ($attributes as $attribute) {
                        if ($owner->isAttributeChanged($attribute)) {
                            $isNewSlug = true;
                            break;
                        }
                    }
                }
            }

            if ($isNewSlug) {
                $slugParts = [];
                foreach ($attributes as $attribute) {
                    $slugParts[] = $owner->{$attribute};
                }
                $slug = Inflector::persianSlug(implode('-', $slugParts));
            } else {
                $slug = $owner->{$this->slugAttribute};
            }
        } else {
            $slug = parent::getValue($event);
        }

        if ($this->ensureUnique && $isNewSlug) {
            $baseSlug = $slug;
            $iteration = 0;
            while (!$this->validateSlug($slug)) {
                $iteration++;
                $slug = $this->generateUniqueSlug($baseSlug, $iteration);
            }
        }
        return $slug;
    }
}

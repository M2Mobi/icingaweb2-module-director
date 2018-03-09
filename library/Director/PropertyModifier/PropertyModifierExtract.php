<?php

namespace Icinga\Module\Director\PropertyModifier;

use Icinga\Module\Director\Hook\PropertyModifierHook;
use Icinga\Module\Director\Web\Form\QuickForm;

class PropertyModifierExtract extends PropertyModifierHook
{
    public static function addSettingsFormFields(QuickForm $form)
    {
        $form->addElement('text', 'key', array(
            'label'       => $form->translate('Key'),
            'required'    => true,
            'description' => $form->translate(
                'Array key or Object property name to extract'
            )
        ));

    }

    public function getName()
    {
        return 'Extract a value from an Array or Object';
    }

    public function transform($value)
    {
        $key = $this->getSetting('key');

        if (is_array($value) && array_key_exists($key, $value)) {
            return $value[$key];
        } else if (is_object($value) && property_exists($value, $key)) {
            return $value->{$key};
        } else {
            return null;
        }

    }
}

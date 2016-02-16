<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;

abstract class FormInputElement extends FluentHtml implements FormElementContract
{
    use FormElement;

    private $input_name;

    /* TODO: define these methods on FormInputElement
->getFormBlockContainer()
->getValue()
protected ->getValueFromAncestor()
->withValue(value) - perhaps in an interface?
     */

    /**
     * @param string|callable $name of input
     * @return $this
     */
    public function withName($name)
    {
        $this->input_name = $name;
        $this->withAttribute('name', function (FormInputElement $input) {
            return $input->getNameAttribute();
        });

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->input_name;
    }

    /**
     * @return string
     */
    public function getNameAttribute()
    {
        //TODO: transform name from dot-notation and take care of multiple attribute
        return $this->input_name;
    }

    /**
     * @return string suitable for label
     */
    public function getHumanName()
    {
        return ucwords(str_replace(['.', '_'], ' ', $this->getName()));
    }

    public function getId($desired_id = null)
    {
        return parent::getId($desired_id ?: $this->getName());
    }


}
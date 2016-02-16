<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;

abstract class FormInputElement extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var string|callable
     */
    private $input_name;

    /* TODO: define these methods on FormInputElement
->getFormBlockContainer()
->getValue()
protected ->getValueFromAncestor()
->withValue(value) - perhaps in an interface?
     */

    /**
     * Set the name of the input element.
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
     * Get the name of the input element.
     * @return string
     */
    public function getName()
    {
        return $this->evaluate($this->input_name);
    }

    /**
     * Get the name attribute of the input element
     * @return string
     */
    public function getNameAttribute()
    {
        //TODO: transform name from dot-notation and take care of multiple attribute
        return $this->getName();
    }

    /**
     * Get a human readable name of the input element.
     * @return string suitable for label
     */
    public function getHumanName()
    {
        return ucwords(str_replace(['.', '_'], ' ', $this->getName()));
    }

    /**
     * Get the element's id string if set, or generate a new id.
     * @param null $desired_id
     * @return string
     */
    public function getId($desired_id = null)
    {
        return parent::getId($desired_id ?: $this->getName());
    }


}
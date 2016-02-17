<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentHtml\FluentHtmlElement;

abstract class FormInputElement extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var string|callable
     */
    private $input_name;

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
        //transform name from dot-notation
        $name_parts = explode('.', $this->getName());
        $name = array_shift($name_parts);
        foreach ($name_parts as $name_part) {
            $name .= "[$name_part]";
        }

        //TODO: multiple attribute should add [] to $name

        return $name;
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
     * Set input value.
     *
     * @param $value string|callable
     * @return $this|FluentHtmlElement
     */
    abstract public function withValue($value);

    /**
     * Get input value.
     *
     * @return string
     */
    abstract public function getValue();

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
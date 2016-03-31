<?php
namespace FewAgency\FluentForm;

class CheckboxInputElement extends AbstractFormControl
{
    /**
     * The checkbox value attribute
     * We don't keep this in the value input-attribute because we want to keep this a bool for checking but print as string in attribute.
     * @var bool|string|callable
     */
    private $value = true;

    /**
     * Indicates if checkbox should be treated as multiple
     * We don't keep this in the multiple input-attribute as it's not allowed on checkboxes
     * @var bool|string|callable
     */
    private $multiple = false;

    public function __construct($name)
    {
        parent::__construct();
        $this->withHtmlElementName('input');
        $this->withName($name);
        $this->withAttribute('type', 'checkbox');
        $this->withAttribute('value', function () {
            return (string)$this->getValue();
        });
        $this->checked(function () {
            return $this->getValue() == $this->getValueFromAncestor($this->getName());
        });
    }

    /**
     * Make checkbox checked.
     * @param bool $checked
     * @return $this
     */
    public function checked($checked = true)
    {
        $this->withAttribute('checked', $checked);

        return $this;
    }

    /**
     * Make checkbox not checked.
     * @return $this
     */
    public function unchecked()
    {
        return $this->checked(false);
    }

    public function isChecked()
    {
        return (bool)$this->getAttribute('checked');
    }

    public function withValue($value)
    {
        $this->value = $value;

        return $this;
    }

    public function getValue()
    {
        return $this->evaluate($this->value);
    }

    /**
     * Make checkbox part of multiple checkboxes sharing same name[] attribute.
     * @param bool|callable $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function isMultiple()
    {
        return (bool)$this->evaluate($this->multiple);
    }
}
<?php
namespace FewAgency\FluentForm;

abstract class AbstractCheckableInput extends AbstractFormControl
{
    /**
     * The input value attribute
     * We don't keep this in the value input-attribute because we want to keep this a bool for checking but print as string in attribute.
     * @var bool|string|callable
     */
    protected $value = true;

    /**
     * Indicates if checkbox should be treated as multiple
     * We don't keep this in the multiple input-attribute as it's not allowed on checkboxes
     * @var bool|string|callable
     */
    protected $multiple = false;

    /**
     * @param string $name of input
     * @param string $type checkbox|radio
     */
    public function __construct($name, $type)
    {
        parent::__construct();
        $this->withHtmlElementName('input');
        $this->withName($name);
        $this->withAttribute('type', $type);
        $this->withAttribute('value', function () {
            return (string)$this->getValue();
        });
        $this->checked(function () {
            return $this->getValue() == $this->getValueFromAncestor($this->getName());
        });
    }

    public function checked($checked = true)
    {
        $this->withAttribute('checked', $checked);

        return $this;
    }
    
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

    public function isMultiple()
    {
        return (bool)$this->evaluate($this->multiple);
    }
}
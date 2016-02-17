<?php
namespace FewAgency\FluentForm\FormInput;

//TODO: subclass these HTML inputs:
// PasswordInputElement
// SubmitInputElement
// RadioInputElement
// CheckboxInputElement
// ButtonInputElement
// FileInputElement

//TODO: subclass these HTML5 inputs:
// NumberInputElement
// DateInputElement
// MonthInputElement
// WeekInputElement
// TimeInputElement
// DatetimeInputElement
// DatetimeLocalInputElement
// EmailInputElement
// SearchInputElement
// UrlInputElement
// ColorInputElement
// RangeInputElement

abstract class InputElement extends FormInputElement
{
    /**
     * @var string|callable
     */
    private $input_value;

    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     */
    public function __construct($name, $type = 'text')
    {
        parent::__construct('input');
        $this->withName($name);
        $this->withAttribute('type', $type);
        $this->withAttribute('value', function (FormInputElement $input) {
            return $input->getValue();
        });
    }

    /**
     * Set input value.
     * @param string|callable|null $value
     * @return $this
     */
    public function withValue($value)
    {
        $this->input_value = $value;

        return $this;
    }

    /**
     * Get input value.
     * @return string|null
     */
    public function getValue()
    {
        $value = $this->evaluate($this->input_value);
        if (is_null($value)) {
            $value = $this->getValueFromAncestor($this->getName());
        }

        return $value;
    }

    /**
     * Make this input disabled
     * @param bool|callable $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        $this->withAttribute('disabled', $disabled);

        return $this;
    }
}
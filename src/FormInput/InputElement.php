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
// TelInputElement
// UrlInputElement
// ColorInputElement
// RangeInputElement

abstract class InputElement extends FormInputElement
{
    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     */
    public function __construct($name, $type = 'text')
    {
        $tag_contents = null;
        parent::__construct('input');
        $this->withName($name);
        $this->withAttribute('type', $type);
    }

    /**
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     * @return static
     */
    public static function create($name, $type = 'text')
    {
        return new static($name, $type);
    }

    /**
     * Set input value
     *
     * @param $value string|callable
     * @return $this
     */
    public function withValue($value)
    {
        $this->withAttribute('value', $value);

        return $this;
    }

}
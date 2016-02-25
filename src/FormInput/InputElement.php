<?php
namespace FewAgency\FluentForm\FormInput;

//TODO: subclass these HTML inputs:
// PasswordInputElement - don't set value
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
// done: EmailInputElement
// SearchInputElement
// UrlInputElement
// ColorInputElement
// RangeInputElement

use FewAgency\FluentForm\Support\FormInputReadonlyElement;
use FewAgency\FluentForm\Support\FormInputSingleValueElement;

abstract class InputElement extends FormInputElement
{
    use FormInputSingleValueElement, FormInputReadonlyElement;

    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     */
    public function __construct($name, $type = 'text')
    {
        parent::__construct();
        $this->withHtmlElementName('input');
        $this->withName($name);
        $this->withAttribute('type', $type);
        $this->withAttribute('value', function (FormInputElement $input) {
            return $input->getValue();
        });
    }
    
}
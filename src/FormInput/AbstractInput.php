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

use FewAgency\FluentForm\AbstractFormControl;
use FewAgency\FluentForm\Support\ReadonlyInputTrait;
use FewAgency\FluentForm\Support\SingleValueInputTrait;

abstract class AbstractInput extends AbstractFormControl
{
    use SingleValueInputTrait, ReadonlyInputTrait;

    /**
     * @param callable|string $name of input
     * @param string $input_type of input, defaults to text
     */
    public function __construct($name, $input_type = 'text')
    {
        parent::__construct();
        $this->withHtmlElementName('input');
        $this->withName($name);
        $this->withAttribute('type', $input_type);
        $this->withAttribute('value', function (AbstractFormControl $input) {
            return $input->getValue();
        });
    }
    
}
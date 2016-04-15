<?php
namespace FewAgency\FluentForm;

//Potentially subclass these HTML inputs:
// SubmitInputElement
// ButtonInputElement
// FileInputElement

//Potentially subclass these HTML5 inputs:
// NumberInputElement
// DateInputElement
// MonthInputElement
// WeekInputElement
// TimeInputElement
// DatetimeInputElement
// DatetimeLocalInputElement
// SearchInputElement
// UrlInputElement
// ColorInputElement
// RangeInputElement

use FewAgency\FluentForm\Support\ReadonlyInputTrait;
use FewAgency\FluentForm\Support\SingleValueInputTrait;

/**
 * Class AbstractInput works as a base for all the <input>s
 * @package FewAgency\FluentForm
 */
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
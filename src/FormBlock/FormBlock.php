<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;


abstract class FormBlock extends FluentHtml implements FormElementContract
{
    use FormElement;
    /**
     * FormBlock constructor.
     * @param FormInputElement $input element
     */
    public function __construct(FormInputElement $input)
    {
        //TODO: add label element
        parent::__construct('div', $input);
        //TODO: save reference to the input element
    }

    public static function create(FormInputElement $input)
    {
        return new static($input);
    }


    /* TODO: implement these methods on FormBlock:
    ->withLabel(text)
    ->getFormBlockContainer()
    ->getAlignmentClasses(column number, bool with_offset=false)
    ->followedBy…Block()
    ->disabled(true)
    ->readonly(true)
    ->required(true)
    ->withDescription(text)
    ->withError(messages)
    ->withWarning(messages)
    ->withSuccess(true)
    ->withFeedback(html)
    ->getInputElement()
    ->getLabelElement()
    ->getDescriptionElement()
    ->getColumnElement(column number)
    ->getScreenReaderOnlyClass()
    ->hideLabel()
    ->withInputAttribute(attributes)
     */
}
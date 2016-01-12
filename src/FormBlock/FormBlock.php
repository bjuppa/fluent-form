<?php
namespace FewAgency\FluentHtml\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentHtml\FluentHtml;

abstract class FormBlock extends FluentHtml implements FormElementContract
{
    /**
     * FormBlock constructor.
     * @param FormInput $input element
     */
    public function __construct(FormInputElement $input)
    {
        //TODO: add label element
        parent::__construct('div', $input);
    }

    public static function create(FormInputElement $input)
    {
        return new static($input);
    }


    /* TODO: implement these methods on FormBlock:
    ->withLabel(text)
    ->getForm()
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
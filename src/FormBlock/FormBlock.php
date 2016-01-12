<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentForm\FormLabel\LabelElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;


abstract class FormBlock extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var LabelElement
     */
    protected $label_element;
    /**
     * @var FormInputElement
     */
    protected $input_element;

    /**
     * FormBlock constructor.
     * @param FormInputElement $input element
     */
    public function __construct(FormInputElement $input)
    {
        parent::__construct('div');
        $this->input_element = $input;
        $this->label_element = new LabelElement();
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
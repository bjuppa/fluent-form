<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentForm\FormLabel\LabelElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtmlElement;


abstract class FormBlock extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var LabelElement
     */
    private $label_element;
    /**
     * @var FormInputElement
     */
    private $input_element;

    /**
     * @return FormInputElement
     */
    public function getInputElement()
    {
        return $this->input_element;
    }

    public function withInputElement(FormInputElement $input_element)
    {
        $this->input_element = $input_element;
        $this->withContent($this->input_element);
        $this->getLabelElement()->forInput($this->input_element);

        return $this;
    }

    /**
     * @return LabelElement
     */
    public function getLabelElement()
    {
        return $this->label_element;
    }

    public function withLabelElement(LabelElement $label_element)
    {
        $this->label_element = $label_element;
        $this->withContent($this->label_element);

        return $this;
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
    ->getDescriptionElement()
    ->getColumnElement(column number)
    ->getScreenReaderOnlyClass()
    ->hideLabel()
    ->withInputAttribute(attributes)
     */

    /**
     * Set this element's parent element.
     *
     * @param FluentHtmlElement|null $parent
     */
    protected function setParent(FluentHtmlElement $parent = null)
    {
        parent::setParent($parent);
        if (!$this->hasHtmlElementName()) {
            $this->withHtmlElementName('div');
        }
        if (!$this->getLabelElement()) {
            $this->withLabelElement($this->createInstanceOf('FormLabel\LabelElement'));
        }
    }


}
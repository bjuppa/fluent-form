<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormLabel\FormLabel;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtmlElement;


abstract class FormBlock extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var FormLabel
     */
    private $label_element;

    /**
     * Get the label element of the block.
     * @return FormLabel
     */
    public function getLabelElement()
    {
        return $this->label_element;
    }

    /**
     * Set the label element of the block.
     * @param FormLabel $label_element
     * @return $this
     */
    public function withLabelElement(FormLabel $label_element)
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
    }


}
<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LabelElement extends AbstractLabel
{
    /**
     * @var AbstractFormControl referenced by the label
     */
    private $for_control_element;

    /**
     * @param string|Htmlable|array|Arrayable|null $html_contents
     */
    public function __construct($html_contents = null)
    {
        parent::__construct($html_contents);
        $this->withHtmlElementName('label');
    }

    /**
     * Set the referenced input for this label.
     * @param AbstractFormControl $control_element that label should reference
     * @return $this
     */
    public function forControl(AbstractFormControl $control_element)
    {
        $this->for_control_element = $control_element;
        $this->withAttribute('for', function () {
            return $this->getControlElement()->getId();
        });
        $this->withDefaultContent(function () use ($control_element) {
            return $control_element->getLabel();
        });

        return $this;
    }

    /**
     * Get referenced input element.
     * @return AbstractFormControl the input element related to this label
     */
    public function getControlElement()
    {
        return $this->for_control_element;
    }
}
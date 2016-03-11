<?php
namespace FewAgency\FluentForm;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LabelElement extends AbstractLabel
{
    /**
     * @var AbstractFormControl referenced by the label
     */
    private $for_input_element;

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
     * @param AbstractFormControl $input that label should reference
     * @return $this
     */
    public function forInput(AbstractFormControl $input)
    {
        $this->for_input_element = $input;
        $this->withAttribute('for', $this->getInputElement()->getId());
        $this->withDefaultContent(function () use ($input) {
            return $input->getLabel();
        });

        return $this;
    }

    /**
     * Get referenced input element.
     * @return AbstractFormControl the input element related to this label
     */
    public function getInputElement()
    {
        return $this->for_input_element;
    }
}
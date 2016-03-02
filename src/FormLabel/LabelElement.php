<?php
namespace FewAgency\FluentForm\FormLabel;

use FewAgency\FluentForm\FormInput\FormInputElement;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LabelElement extends FormLabel
{
    /**
     * @var FormInputElement referenced by the label
     */
    private $for_input_element;

    /**
     * LabelElement constructor.
     * @param string|Htmlable|array|Arrayable|null $label_contents
     */
    public function __construct($label_contents = null)
    {
        parent::__construct('label', $label_contents);
    }

    /**
     * Set the referenced input for this label.
     * @param FormInputElement $input that label should reference
     * @return $this
     */
    public function forInput(FormInputElement $input)
    {
        $this->for_input_element = $input;
        $this->withAttribute('for', function (LabelElement $label) {
            return $label->getInputElement()->getId();
        });

        $this->withDefaultContent(function () use ($input) {
            return $input->getLabel();
        });

        return $this;
    }

    /**
     * Get referenced input element.
     * @return FormInputElement the input element related to this label
     */
    public function getInputElement()
    {
        return $this->for_input_element;
    }
}
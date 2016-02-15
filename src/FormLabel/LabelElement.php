<?php
namespace FewAgency\FluentForm\FormLabel;

use FewAgency\FluentForm\FormInput\FormInputElement;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentForm\Support\FormElementContract;
use FewAgency\FluentHtml\FluentHtml;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

class LabelElement extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * @var FormInputElement
     */
    protected $for_input_element;

    /**
     * LabelElement constructor.
     * @param string|Htmlable|array|Arrayable|null $label_contents
     */
    public function __construct($label_contents = null)
    {
        parent::__construct('label', $label_contents);
        $this->onlyDisplayedIfHasContent();
    }

    /**
     * @param FormInputElement $input
     * @return $this
     */
    public function forInput(FormInputElement $input)
    {
        $this->for_input_element = $input;
        $this->withAttribute('for', function (LabelElement $label) {
            return $label->getInputElement()->getId();
        });

        $this->withDefaultContent(function () use ($input) {
            return $input->getHumanName();
        });

        return $this;
    }

    /**
     * @return FormInputElement the input element related to this label
     */
    public function getInputElement()
    {
        return $this->for_input_element;
    }
}
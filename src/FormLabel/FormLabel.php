<?php
namespace FewAgency\FluentForm\FormLabel;

use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentForm\Support\FormElementContract;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

abstract class FormLabel extends FluentHtml implements FormElementContract
{
    use FormElement;

    /**
     * FormLabel constructor.
     * @param string $html_element_name
     * @param string|Htmlable|array|Arrayable|null $label_contents
     */
    public function __construct($html_element_name, $label_contents = null)
    {
        parent::__construct($html_element_name, $label_contents);
        $this->onlyDisplayedIfHasContent();
    }
}
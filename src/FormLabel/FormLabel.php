<?php
namespace FewAgency\FluentForm\FormLabel;

use FewAgency\FluentHtml\FluentHtmlElement;
use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentForm\Support\FormElementContract;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

abstract class FormLabel extends FluentHtmlElement implements FormElementContract
{
    use FormElement;

    /**
     * FormLabel constructor.
     * @param string|Htmlable|array|Arrayable|null $html_contents
     */
    public function __construct($html_contents = null)
    {
        parent::__construct();
        $this->onlyDisplayedIfHasContent();
        $this->withContent($html_contents);
    }
}
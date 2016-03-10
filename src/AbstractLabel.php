<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentHtml\FluentHtmlElement;
use FewAgency\FluentForm\Support\FormElementTrait;
use FewAgency\FluentForm\Support\FormElementContract;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\Support\Arrayable;

abstract class AbstractLabel extends FluentHtmlElement implements FormElementContract
{
    use FormElementTrait;

    /**
     * @param string|Htmlable|array|Arrayable|null $html_contents
     */
    public function __construct($html_contents = null)
    {
        parent::__construct();
        $this->onlyDisplayedIfHasContent();
        $this->withContent($html_contents);
    }
}
<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormInputSingleValueElement;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class ButtonElement extends FormInputElement
{
    use FormInputSingleValueElement;

    /**
     * @param string|Htmlable|array|Arrayable $tag_contents
     * @param string $button_type
     */
    public function __construct($tag_contents, $button_type = "submit")
    {
        parent::__construct();
        $this->withHtmlElementName('button');
        $this->withContent($tag_contents);
        $this->withAttribute('type', $button_type);
    }
}
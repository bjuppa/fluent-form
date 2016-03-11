<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\SingleValueInputTrait;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Htmlable;

class ButtonElement extends AbstractFormControl
{
    use SingleValueInputTrait;

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
        $this->withAttribute('value', function (AbstractFormControl $input) {
            return $input->getValue();
        });
    }
}
<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\ReadonlyInputTrait;
use FewAgency\FluentForm\Support\SingleValueInputTrait;

class TextareaElement extends AbstractFormControl
{
    use SingleValueInputTrait, ReadonlyInputTrait;

    /**
     * @param callable|string $name of input
     */
    public function __construct($name)
    {
        parent::__construct();
        $this->withHtmlElementName('textarea');
        $this->withName($name);
        $this->withDefaultContent(function (TextareaElement $input) {
            return $input->getValue();
        });
    }

}
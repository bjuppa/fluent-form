<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\ReadonlyInputTrait;
use FewAgency\FluentForm\Support\SingleValueInputTrait;

class TextareaElement extends FormInputElement
{
    use SingleValueInputTrait, ReadonlyInputTrait;

    /**
     * TextareaElement constructor.
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
<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormInputReadonlyElement;
use FewAgency\FluentForm\Support\FormInputSingleValueElement;

class TextareaElement extends FormInputElement
{
    use FormInputSingleValueElement, FormInputReadonlyElement;

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
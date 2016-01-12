<?php
namespace FewAgency\FluentForm\FormInput;

class TelInputElement extends TextInputElement
{
    /**
     * @param callable|string $name of input
     */
    public function __construct($name)
    {
        parent::__construct($name, 'tel');
        // These attributes helps for mobile users according to http://baymard.com/labs/touch-keyboard-types
        $this->withAttribute('autocorrect', 'off');
        $this->withAttribute('autocomplete', 'tel');
    }
}
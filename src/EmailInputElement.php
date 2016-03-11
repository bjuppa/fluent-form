<?php
namespace FewAgency\FluentForm;

class EmailInputElement extends TextInputElement
{
    /**
     * @param callable|string $name of input
     */
    public function __construct($name = 'email')
    {
        parent::__construct($name, 'email');
        // These attributes helps for mobile users according to http://baymard.com/labs/touch-keyboard-types
        $this->withAttribute('autocapitalize', 'off');
        $this->withAttribute('autocorrect', 'off');
        $this->withAttribute('autocomplete', 'email');
    }
}
<?php
namespace FewAgency\FluentForm\FormInput;

class HiddenInputElement extends InputElement
{
    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $value of input
     */
    public function __construct($name, $value = null)
    {
        parent::__construct($name, 'hidden');
        if (!empty($value)) {
            $this->withValue($value);
        }
    }
}
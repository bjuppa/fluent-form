<?php
namespace FewAgency\FluentForm\FormInput;

class HiddenInputElement extends AbstractInput
{
    /**
     * @param callable|string $name
     * @param string|callable $value
     */
    public function __construct($name, $value = null)
    {
        parent::__construct($name, 'hidden');
        $this->withValue($value);
    }
}
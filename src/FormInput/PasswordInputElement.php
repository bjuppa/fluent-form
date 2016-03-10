<?php
namespace FewAgency\FluentForm\FormInput;

class PasswordInputElement extends AbstractInput
{
    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $input_type of input, defaults to password
     */
    public function __construct($name, $input_type = 'password')
    {
        parent::__construct($name, $input_type);
    }


    /**
     * Passwords should never have value set.
     * @return null
     */
    public function getValue()
    {
        return null;
    }

}
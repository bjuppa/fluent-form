<?php
namespace FewAgency\FluentForm;

class PasswordInputElement extends AbstractInput
{
    /**
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
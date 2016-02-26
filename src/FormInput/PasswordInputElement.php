<?php
namespace FewAgency\FluentForm\FormInput;

class PasswordInputElement extends InputElement
{
    /**
     * Passwords should never have value set.
     * @return null
     */
    public function getValue()
    {
        return null;
    }

}
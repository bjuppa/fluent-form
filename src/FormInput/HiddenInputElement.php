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
        if(!empty($value)) {
            $this->withValue($value);
        }
    }

    /**
     * @param callable|string $name of input
     * @param string $value of input
     * @return static
     */
    public static function create($name, $value = null)
    {
        return new static($name, $value);
    }
}
<?php
namespace FewAgency\FluentForm\FormBlock;

use FewAgency\FluentForm\FormInput\TextInputElement;

class InputBlock extends FormBlock
{
    /**
     * InputBlock constructor.
     * @param string $name of input
     * @param string $type of input or fully qualified classname
     */
    public function __construct($name, $type = 'text')
    {
        $classname = '\FewAgency\FluentForm\FormInput\typeInputElement' . $type . 'InputElement';
        if (class_exists($classname)) {
            $input = new $classname($name);
        } elseif (class_exists($type)) {
            $input = new $type($name);
        } else {
            $input = new TextInputElement($name, $type);
        }
        parent::__construct($input);
        $this->withContent($this->label_element, $this->input_element);
        $this->label_element->forInput($this->input_element);
    }

    /**
     * @param string $name
     * @param string $type
     * @return static
     */
    public static function create($name, $type = 'text')
    {
        return new static($name, $type);
    }
}
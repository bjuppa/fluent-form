<?php
namespace FewAgency\FluentHtml\FormBlock;

use FewAgency\FluentForm\Support\FormElement;

class InputBlock extends FormBlock
{
    use FormElement;

    public function __construct($name, $type = 'text')
    {
        $classname = '\FewAgency\FluentForm\FormInput\typeInputElement' . $type . 'InputElement';
        if (class_exists($classname)) {
            $input = new $classname($name);
        } else {
            //TODO: Set input to standard text
        }
        //TODO: save reference to the input element
        parent::__construct($input);
    }

    //TODO: override create() with same params as constructor
}
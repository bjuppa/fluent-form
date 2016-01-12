<?php
namespace FewAgency\FluentHtml\FormBlock;

class InputBlock extends FormBlock
{
    public function __construct($name, $type = 'text')
    {
        //TODO: generate an input element instance of $typeInputElement
        $classname = '\FewAgency\FluentForm\FormInput\typeInputElement'.$type.'InputElement';
        if(class_exists($classname)) {
            $input = new $classname($name);
        } else {
            //TODO: Set input to standard text
        }
        parent::__construct($input);
    }

    //TODO: override create() with same params as constructor
}
<?php
namespace FewAgency\FluentForm;

class RadioInputElement extends AbstractCheckableInput
{
    public function __construct($name)
    {
        parent::__construct($name, 'radio');
    }
}
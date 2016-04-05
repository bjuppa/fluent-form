<?php
namespace FewAgency\FluentForm;

class CheckboxInputElement extends AbstractCheckableInput
{
    public function __construct($name)
    {
        parent::__construct($name, 'checkbox');
    }

    /**
     * Make checkbox part of multiple checkboxes sharing same name[] attribute.
     * @param bool|callable $multiple
     * @return $this
     */
    public function multiple($multiple = true)
    {
        $this->multiple = $multiple;

        return $this;
    }
}
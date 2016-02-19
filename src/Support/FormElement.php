<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\FluentForm;
use FewAgency\FluentForm\FormBlockContainer\FormBlockContainer;

trait FormElement
{
    /**
     * Get the form element for the element
     * @return FluentForm|null
     */
    public function getForm()
    {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\FluentForm');
    }

    /**
     * Get the the block container element if this element is part of one.
     * @return FormBlockContainer|null
     */
    public function getFormBlockContainer()
    {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\FormBlockContainer\FormBlockContainer');
    }

    /**
     * Get input values set higher up in the form structure.
     * @param string $key in dot-notation
     * @return string|null
     */
    protected function getValueFromAncestor($key)
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->getValue($key);
        }

        return null;
    }
}
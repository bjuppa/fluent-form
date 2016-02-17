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
    public function getForm() {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\FluentForm');
    }

    /**
     * Get the the block container element if this element is part of one.
     * @return FormBlockContainer|null
     */
    public function getFormBlockContainer() {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\FormBlockContainer\FormBlockContainer');
    }
}
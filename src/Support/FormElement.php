<?php
namespace FewAgency\FluentForm\Support;

trait FormElement
{
    /**
     * Get the form element for the element
     * @return \FewAgency\FluentForm\FluentForm
     */
    public function getForm() {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\FluentForm');
    }
}
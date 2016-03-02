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
     * @return mixed|null
     */
    protected function getValueFromAncestor($key)
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->getValue($key);
        }

        return null;
    }

    /**
     * Get labels set higher up in the form structure.
     * @param string $key in dot-notation
     * @return mixed|null
     */
    protected function getLabelFromAncestor($key)
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->getLabel($key);
        }

        return null;
    }

    /**
     * Get error messages set higher up in the form structure.
     * @param string $key in dot-notation
     * @return array
     */
    protected function getErrorsFromAncestor($key)
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->getErrors($key);
        }

        return [];
    }

    /**
     * Get warning messages set higher up in the form structure.
     * @param string $key in dot-notation
     * @return array
     */
    protected function getWarningsFromAncestor($key)
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->getWarnings($key);
        }

        return [];
    }

    /**
     * Find out if this element is placed in an inline context.
     * @return bool
     */
    public function isInline()
    {
        if ($ancestor = $this->getFormBlockContainer()) {
            return $ancestor->isInline();
        }

        return false;
    }
}
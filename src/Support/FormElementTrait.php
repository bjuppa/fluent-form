<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\FieldsetElement;
use FewAgency\FluentForm\FluentForm;
use FewAgency\FluentForm\AbstractControlBlockContainer;

trait FormElementTrait
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
     * @return AbstractControlBlockContainer|FieldsetElement|null
     */
    public function getControlBlockContainer()
    {
        return $this->getAncestorInstanceOf('FewAgency\FluentForm\AbstractControlBlockContainer');
    }

    /**
     * Get input values set higher up in the form structure.
     * @param string $key in dot-notation
     * @return mixed|null
     */
    protected function getValueFromAncestor($key)
    {
        if ($ancestor = $this->getControlBlockContainer()) {
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
        if ($ancestor = $this->getControlBlockContainer()) {
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
        if ($ancestor = $this->getControlBlockContainer()) {
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
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->getWarnings($key);
        }

        return [];
    }

    /**
     * Get success booleans set higher up in the form structure.
     * @param string $key in dot-notation
     * @return bool|null
     */
    protected function hasSuccessFromAncestor($key)
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->hasSuccess($key);
        }

        return null;
    }

    /**
     * Get disabled-booleans set higher up in the form structure.
     * @param string $key in dot-notation
     * @return bool|null
     */
    protected function isDisabledFromAncestor($key)
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->isDisabled($key);
        }

        return null;
    }

    /**
     * Get readonly-booleans set higher up in the form structure.
     * @param string $key in dot-notation
     * @return bool|null
     */
    protected function isReadonlyFromAncestor($key)
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->isReadonly($key);
        }

        return null;
    }

    /**
     * Get required-booleans set higher up in the form structure.
     * @param string $key in dot-notation
     * @return bool|null
     */
    protected function isRequiredFromAncestor($key)
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->isRequired($key);
        }

        return null;
    }

    /**
     * Find out if this element is placed in a horizontally aligned context.
     * @return bool
     */
    public function isAligned()
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->isAligned();
        }

        return false;
    }

    /**
     * Find out if this element is placed in an inline context.
     * @return bool
     */
    public function isInline()
    {
        if ($ancestor = $this->getControlBlockContainer()) {
            return $ancestor->isInline();
        }

        return false;
    }
}
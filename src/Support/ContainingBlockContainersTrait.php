<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\FieldsetElement;

trait ContainingBlockContainersTrait
{
    /**
     * Put a new fieldset form block container in this container and return it.
     * @return FieldsetElement
     */
    public function containingFieldset()
    {
        $fieldset = $this->createInstanceOf('FieldsetElement');
        $this->withContent($fieldset);

        return $fieldset;
    }

    abstract protected function createInstanceOf($classname, $parameters = []);
}
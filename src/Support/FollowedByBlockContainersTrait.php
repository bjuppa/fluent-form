<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\FieldsetElement;

trait FollowedByBlockContainersTrait
{
    /**
     * Put a new fieldset form block container after this block and return it.
     * @return FieldsetElement
     */
    public function followedByFieldset()
    {
        $fieldset = $this->createInstanceOf('FieldsetElement');
        $this->followedBy($fieldset);

        return $fieldset;
    }
}
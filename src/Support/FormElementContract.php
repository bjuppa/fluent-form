<?php
namespace FewAgency\FluentForm\Support;

use FewAgency\FluentForm\FluentForm;
use FewAgency\FluentForm\AbstractControlBlockContainer;

/**
 * Contract for all FluentHtml elements that are in forms
 */
interface FormElementContract
{
    /**
     * Get the form element for the element.
     * @return FluentForm|null
     */
    public function getForm();

    /**
     * Get the the block container element if this element is part of one.
     * @return AbstractControlBlockContainer|null
     */
    public function getFormBlockContainer();
}
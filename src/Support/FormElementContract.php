<?php
namespace FewAgency\FluentForm\Support;

/*
 * Contract for all FluentHtml elements that are in forms
*/
interface FormElementContract
{
    /**
     * Get the form element for the element
     * @return \FewAgency\FluentForm\FluentForm
     */
    public function getForm();
}
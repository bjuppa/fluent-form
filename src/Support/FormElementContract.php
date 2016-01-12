<?php
namespace FewAgency\FluentForm\Support;

interface FormElementContract
{
    /**
     * @return \FewAgency\FluentForm\FluentForm
     */
    public function getForm();
}
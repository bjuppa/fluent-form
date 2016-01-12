<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentHtml\FluentHtml;

abstract class FormInputElement extends FluentHtml
{
    /* TODO: define these methods on FormInputElement
 ->getForm()
->getFormBlockContainer()
->getValue()
protected ->getValueFromAncestor()
->withValue(value) - perhaps in an interface?
     */

    /**
     * @param string|callable $name of input
     * @return $this
     */
    public function withName($name)
    {
        //TODO: add dot-notation to withName(), set name in an instance variable?
        $this->withAttribute('name', $name);
        return $this;
    }
}
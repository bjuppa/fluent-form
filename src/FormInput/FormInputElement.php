<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentForm\Support\FormElement;
use FewAgency\FluentHtml\FluentHtml;
use FewAgency\FluentForm\Support\FormElementContract;

abstract class FormInputElement extends FluentHtml implements FormElementContract
{
    use FormElement;

    /* TODO: define these methods on FormInputElement
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
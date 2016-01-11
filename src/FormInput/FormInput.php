<?php
namespace FewAgency\FluentForm\FormInput;


trait FormInput
{
    /* TODO: implement these methods
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
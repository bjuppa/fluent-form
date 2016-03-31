<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\SelectorControlContract;

class SelectBlock extends InputBlock implements SelectorControlContract
{
    /**
     * @param string $name if input
     * @param mixed $options
     */
    public function __construct($name, $options = null)
    {
        parent::__construct($name, 'select');
        $this->withOptions($options);
    }

    /**
     * @return SelectElement
     */
    public function getInputElement()
    {
        return parent::getInputElement();
    }


    public function withOptions($options)
    {
        foreach (func_get_args() as $options) {
            $this->getInputElement()->withOptions($options);
        }

        return $this;
    }

    public function withSelectedOptions($options)
    {
        foreach (func_get_args() as $options) {
            $this->getInputElement()->withSelectedOptions($options);
        }

        return $this;
    }

    public function isOptionSelected($option)
    {
        return $this->getInputElement()->isOptionSelected($option);
    }

    public function withDisabledOptions($options)
    {
        foreach (func_get_args() as $options) {
            $this->getInputElement()->withDisabledOptions($options);
        }

        return $this;
    }

    public function isOptionDisabled($option)
    {
        return $this->getInputElement()->isOptionDisabled($option);
    }

    public function multiple($multiple=true)
    {
        $this->getInputElement()->multiple($multiple);

        return $this;
    }

    public function isMultiple()
    {
        return $this->getInputElement()->isMultiple();
    }
}
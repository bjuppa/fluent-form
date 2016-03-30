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


    public function withOptions($options)
    {
        //TODO: send along func_get_args to withOptions
        $this->getInputElement()->withOptions($options);

        return $this;
    }

    public function withSelectedOptions($options)
    {
        $this->getInputElement()->withSelectedOptions($options);

        return $this;
    }

    public function isOptionSelected($option)
    {
        return $this->getInputElement()->isOptionSelected($option);
    }

    public function withDisabledOptions($options)
    {
        // TODO: Implement withDisabledOptions() method.
        return $this;
    }

    public function isOptionDisabled($option)
    {
        // TODO: Implement isOptionDisabled() method.
    }

    public function multiple($multiple)
    {
        // TODO: Implement multiple() method.
        return $this;
    }

    public function isMultiple()
    {
        // TODO: Implement isMultiple() method.
    }
}
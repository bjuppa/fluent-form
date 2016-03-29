<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\name;
use FewAgency\FluentForm\Support\SelectContract;

class SelectBlock extends InputBlock implements SelectContract
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
     * Add options to select from.
     * The basic input is an array of $value=>$display_string
     * More advanced input can have options sub-grouped by $group_title=>$options_array
     * @param array $options
     * @return $this
     */
    public function withOptions($options)
    {
        //TODO: send along func_get_args to withOptions
        $this->getInputElement()->withOptions($options);

        return $this;
    }

    /**
     * Make an option selected
     * @param string $options name to select
     * @return $this
     */
    public function selected($options)
    {
        $this->getInputElement()->selected($options);

        return $this;
    }

    /**
     * Check if an option is selected
     * @param string $option value to check if selected
     * @return bool
     */
    public function isSelected($option)
    {
        return $this->getInputElement()->isSelected($option);
    }
}
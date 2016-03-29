<?php
namespace FewAgency\FluentForm\Support;

interface SelectContract
{
    /**
     * Add options to select from.
     * The basic input is an array of $value=>$display_string
     * More advanced input can have options sub-grouped by $group_title=>$options_array
     * @param array $options
     * @return $this
     */
    public function withOptions($options);

    /**
     * Make an options selected
     * @param string $options,... values to select
     * @return $this
     */
    public function selected($options);

    /**
     * Check if an option is selected
     * @param string $option value to check if selected
     * @return bool
     */
    public function isSelected($option);
    
    //TODO: add disabled and isDisabled to SelectContract
}
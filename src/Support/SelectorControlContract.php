<?php
namespace FewAgency\FluentForm\Support;

use Illuminate\Contracts\Support\Arrayable;

interface SelectorControlContract
{
    /**
     * Add options to select from.
     * The basic input is an array of $value=>$display_string
     * More advanced input can have options sub-grouped by $group_title=>$options_array
     * @param array|Arrayable $options
     * @return $this
     */
    public function withOptions($options);

    /**
     * Make options selected.
     * @param string|callable|array|Arrayable $options,... values to select
     * @return $this
     */
    public function withSelectedOptions($options);

    /**
     * Check if an option is selected.
     * @param string $option value to check if selected
     * @return bool
     */
    public function isOptionSelected($option);

    /**
     * Make options disabled.
     * @param string|callable|array|Arrayable $options,... values to disable
     * @return $this
     */
    public function withDisabledOptions($options);

    /**
     * Check if an option is disabled.
     * @param string $option value to check if disabled
     * @return bool
     */
    public function isOptionDisabled($option);

    /**
     * Enable selection of multiple items.
     * @param bool|callable $multiple
     * @return $this
     */
    public function multiple($multiple);

    /**
     * Check if selector allows selection of multiple items.
     * @return bool
     */
    public function isMultiple();
}
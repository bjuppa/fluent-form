<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\SelectContract;
use FewAgency\FluentHtml\HtmlBuilder;
use Illuminate\Support\Collection;

class SelectElement extends AbstractFormControl implements SelectContract
{
    /**
     * @var Collection of contents (options) for select element
     */
    private $options;

    /**
     * @var Collection of selected option values
     */
    private $selected_options;

    public function __construct($name, $options = null)
    {
        parent::__construct();
        $this->options = new Collection();
        $this->selected_options = new Collection();
        $this->withHtmlElementName('select');
        $this->withName($name);
        $this->withOptions($options);
        $this->withContent(function () {
            return $this->getOptionElements();
        });
    }

    /* TODO: implement methods on SelectElement:
->multiple(true) appends [] to name attribute if true
    */

    /**
     * Set selected option value.
     *
     * @param $value string|callable
     * @return $this
     */
    public function withValue($value)
    {
        return $this->selected($value);
    }

    /**
     * Get selected option values.
     *
     * @return Collection
     */
    public function getValue()
    {
        return $this->evaluate($this->selected_options)->flatten();
    }

    /**
     * Add options to select from.
     * The basic input is an array of $value=>$display_string
     * More advanced input can have options sub-grouped by $group_title=>$options_array
     * @param array $options,...
     * @return $this
     */
    public function withOptions($options)
    {
        foreach (array_filter(func_get_args()) as $options) {
            if (is_string($options)) {
                $options[$options] = $options;
            }
            $this->options->push($options);
        }

        return $this;
    }

    public function withOptionGroup($label, $options)
    {
        return $this->withOptions([$label => $options]);
    }

    protected function getOptionElements()
    {
        $option_elements = new Collection();
        foreach ($this->evaluate($this->options) as $options) {
            foreach ($options as $value => $option) {
                if (is_array($option) and is_string($value)) {
                    $option_elements->push($this->generateOptgroupElement($value, $option));
                } else {
                    $option_elements->push($this->generateOptionElement($value, $option));
                }
            }
        }

        return $option_elements;
    }

    protected function generateOptionElement($value, $content)
    {
        return $this->createFluentHtmlElement('option', $content)
            ->withAttribute('value', $value)
            ->withAttribute('selected', function () use ($value) {
                return $this->isSelected($value);
            });
        //TODO: set disabled on options
    }

    /**
     * Make option(s) selected
     * @param string|callable $options,... option value to select
     * @return $this
     */
    public function selected($options)
    {
        $this->selected_options = $this->selected_options->merge(HtmlBuilder::flatten(func_get_args()));

        return $this;
    }

    /**
     * Check if an option is selected
     * @param string|callable $option name to check
     * @return bool
     */
    public function isSelected($option)
    {
        $option = $this->evaluate($option);

        if($this->getAttribute('multiple')) {
            return $this->getValue()->contains($option);
        } else {
            return $this->getValue()->last() == $option;
        }
    }
}
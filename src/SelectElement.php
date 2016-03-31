<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\MapCollection;
use FewAgency\FluentForm\Support\SelectorControlContract;
use FewAgency\FluentHtml\HtmlBuilder;
use Illuminate\Support\Collection;

class SelectElement extends AbstractFormControl implements SelectorControlContract
{
    /**
     * @var Collection of contents (options) for select element
     */
    private $options;

    /**
     * @var Collection of selected option values
     */
    private $selected_options;

    /**
     * @var MapCollection of disabled option values
     */
    private $disabled_options;

    public function __construct($name, $options = null)
    {
        parent::__construct();
        $this->options = new Collection();
        $this->selected_options = new Collection(); //TODO: make selected_options a MapCollection?
        $this->disabled_options = new MapCollection();
        $this->withHtmlElementName('select');
        $this->withName($name);
        $this->withOptions($options);
        $this->withContent(function () {
            return $this->getOptionElements();
        });
    }

    /**
     * Set selected option value.
     *
     * @param $value string|callable
     * @return $this
     */
    public function withValue($value)
    {
        return $this->withSelectedOptions($value);
    }

    /**
     * Get selected option values.
     *
     * @return Collection
     */
    public function getValue()
    {
        if ($this->selected_options->isEmpty()) {
            return new Collection($this->getValueFromAncestor($this->getName()));
        }

        return $this->evaluate($this->selected_options)->flatten();
    }

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
                if ($option instanceof Collection and is_string($value)) {
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
                return $this->isOptionSelected($value);
            })->withAttribute('disabled', function () use ($value) {
                return $this->isOptionDisabled($value);
            });
    }

    protected function generateOptgroupElement($label, $options)
    {
        $optgroup_element = $this->createFluentHtmlElement('optgroup')->withAttribute('label', $label);
        foreach ($options as $value => $option) {
            $optgroup_element->withContent($this->generateOptionElement($value, $option));
        }

        return $optgroup_element;
    }

    public function withSelectedOptions($options)
    {
        $this->selected_options = $this->selected_options->merge(HtmlBuilder::flatten(func_get_args()));

        return $this;
    }

    public function isOptionSelected($option)
    {
        if ($this->isMultiple()) {
            return $this->getValue()->contains($option);
        } else {
            return $this->getValue()->last() == $option;
        }
    }

    public function withDisabledOptions($options)
    {
        $this->disabled_options->prependMaps(func_get_args());

        return $this;
    }

    public function isOptionDisabled($option)
    {
        return $this->evaluate($this->disabled_options)->firstBoolean($option, function () use ($option) {
            $option = implode('.', [$this->getName(), $option]);

            return $this->isDisabledFromAncestor($option);
        });
    }

    /**
     * Enable selection of multiple items.
     * @param bool|callable $multiple
     * @return $this
     */
    public function multiple($multiple)
    {
        $this->withAttribute('multiple', $multiple);

        return $this;
    }

    public function isMultiple()
    {
        return (bool)$this->getAttribute('multiple');
    }
}
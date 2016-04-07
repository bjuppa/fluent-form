<?php
namespace FewAgency\FluentForm;

use FewAgency\FluentForm\Support\FormElementTrait;
use FewAgency\FluentHtml\FluentHtmlElement;
use FewAgency\FluentForm\Support\FormElementContract;

abstract class AbstractFormControl extends FluentHtmlElement implements FormElementContract
{
    use FormElementTrait;

    /**
     * @var string|callable
     */
    private $input_name = '';

    /**
     * @var bool|callable
     */
    private $invalid = false;

    /**
     * Set the name of the input element.
     * @param string|callable $name of input in dot-notation
     * @return $this
     */
    public function withName($name)
    {
        $this->input_name = $name;
        $this->withAttribute('name', function (AbstractFormControl $input) {
            return $input->getNameAttribute();
        });

        return $this;
    }

    /**
     * Get the name of the input element.
     * @return string in dot-notation
     */
    public function getName()
    {
        return implode('.', (array)$this->evaluate($this->input_name));
    }

    /**
     * Get the name attribute of the input element
     * @return string|null
     */
    public function getNameAttribute()
    {
        //transform name from dot-notation
        $name_parts = explode('.', $this->getName());
        $name = array_shift($name_parts);
        foreach ($name_parts as $name_part) {
            $name .= "[$name_part]";
        }

        if (empty($name)) {
            return null;
        }

        if ($this->isMultiple()) {
            $name .= '[]';
        }

        return $name;
    }

    /**
     * Get a human readable name of the input element.
     * @return string suitable for label
     */
    public function getHumanName()
    {
        return ucwords(str_replace(['.', '_'], ' ', $this->getName()));
    }

    /**
     * Get a label for this input element.
     * @return string|mixed
     */
    public function getLabel()
    {
        return $this->getLabelFromAncestor($this->getName()) ?: $this->getHumanName();
    }

    /**
     * Set input value.
     *
     * @param $value string|callable|mixed
     * @return $this
     */
    abstract public function withValue($value);

    /**
     * Get input value.
     *
     * @return string|array
     */
    abstract public function getValue();

    /**
     * Get the element's id string if set, or generate a new id.
     * @param null $desired_id
     * @return string
     */
    public function getId($desired_id = null)
    {
        return parent::getId($desired_id ?: $this->getName());
    }

    /**
     * Make this input disabled.
     * @param bool|callable $disabled
     * @return $this
     */
    public function disabled($disabled = true)
    {
        $this->withAttribute('disabled', $disabled);

        return $this;
    }

    /**
     * Check if input is disabled.
     * @return bool true if input is disabled
     */
    public function isDisabled()
    {
        return (bool)$this->getAttribute('disabled');
    }

    /**
     * Make this input required.
     * @param bool|callable $required
     * @return $this
     */
    public function required($required = true)
    {
        $this->withAttribute('required', $required);

        return $this;
    }

    /**
     * Check if input is required.
     * @return bool true if input is required
     */
    public function isRequired()
    {
        return (bool)$this->getAttribute('required');
    }

    /**
     * Make this input invalid.
     * @param bool|callable $invalid
     * @return $this
     */
    public function invalid($invalid = true)
    {
        $this->invalid = $invalid;
        $this->withAttribute('aria-invalid', function () {
            return $this->isInvalid() ? 'true' : null;
        });

        return $this;
    }

    /**
     * Check if input is invalid.
     * @return bool true if input is invalid
     */
    public function isInvalid()
    {
        return (bool)$this->evaluate($this->invalid);
    }

    /**
     * Check if input should be treated as multiple option, i.e. add [] to name attribute
     * @return bool
     */
    public function isMultiple()
    {
        return (bool)$this->getAttribute('multiple');
    }

    /**
     * Wrap the input in a label element
     * @return LabelElement
     */
    public function wrappedInLabel()
    {
        $label = $this->createInstanceOf('LabelElement');

        $this->withWrapper($label);

        $label->withContent(function (LabelElement $label) {
            return $label->getContentCount() < 3 ? $this->getLabel() : null;
        });

        return $label;
    }
}
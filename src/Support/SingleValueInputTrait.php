<?php
namespace FewAgency\FluentForm\Support;


trait SingleValueInputTrait
{
    /**
     * @var string|callable
     */
    private $input_value;

    /**
     * Set input value.
     * @param string|callable|null $value
     * @return $this
     */
    public function withValue($value)
    {
        $this->input_value = $value;

        return $this;
    }

    /**
     * Get input value.
     * @return string|null
     */
    public function getValue()
    {
        $value = $this->evaluate($this->input_value);
        if (!isset($value)) {
            $value = $this->getValueFromAncestor($this->getName());
        }

        return $value;
    }

    abstract protected function evaluate($value);
}
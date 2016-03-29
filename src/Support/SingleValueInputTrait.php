<?php
namespace FewAgency\FluentForm\Support;

trait SingleValueInputTrait
{
    /**
     * @var string|callable|mixed
     */
    private $input_value;

    /**
     * Set input value.
     * @param string|callable|mixed $value may be arrayish which will usually result in a comma-separated value
     * @return $this
     */
    public function withValue($value)
    {
        $this->input_value = $value;

        return $this;
    }

    /**
     * Get input value.
     * @return string|mixed
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
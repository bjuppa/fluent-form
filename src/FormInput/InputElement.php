<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentHtml\FluentHtml;

abstract class InputElement extends FluentHtml
{
    use FormInput;

    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     */
    public function __construct($name, $type = 'text')
    {
        $tag_contents = null;
        parent::__construct('input');
        $this->withName($name);
        $this->withAttribute('type', $type);
    }

    /**
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     * @return static
     */
    public static function create($name, $type = 'text')
    {
        return new static($name, $type);
    }

    /**
     * Set input value
     *
     * @param $value string|callable
     * @return $this
     */
    public function withValue($value)
    {
        $this->withAttribute('value', $value);

        return $this;
    }

}
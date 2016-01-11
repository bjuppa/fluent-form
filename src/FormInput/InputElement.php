<?php
namespace FewAgency\FluentForm\FormInput;

use FewAgency\FluentHtml\FluentHtml;

class InputElement extends FluentHtml
{
    /**
     * InputElement constructor.
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     */
    public function __construct($name, $type = 'text')
    {
        $tag_contents = null;
        $tag_attributes = compact('name', 'type');
        parent::__construct('input', $tag_contents, $tag_attributes);
    }

    /**
     * @param callable|string $name of input
     * @param string $type of input, defaults to text
     * @return static
     */
    public static function create($name, $type = 'text')
    {
        return parent::create($name, $type);
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